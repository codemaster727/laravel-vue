<?php

namespace App\Http\Controllers\Api\Manager;

use Log;
use Auth;
use Session;
use App\Models\Manager;
use App\Mail\MailManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\User\Auth\AuthRequest;
use App\Http\Requests\Manager\ManagerRequest;
use Illuminate\Auth\Passwords\PasswordBroker;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\SentPasswordRequest;
use App\Http\Resources\Manager\ManagerResource;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ResetPasswordByOldPassRequest;

class ManagerController extends ApiBaseController
{
    // 認証
    public function auth(AuthRequest $request) {
        $result = array(
            'session_id'    => '',
        );
        $params = array(
            'email'             => request('email', ''),
            'password'          => request('password', ''),
            'remember_token'    => request('remember_token', false),
        );
        $user = Manager::where('email', $params['email'])->first();
        if (isset($user) && password_verify($params['password'], $user->password)) {
            $user = Auth::guard('manager')->loginUsingId($user->id, $params['remember_token']);
            Session::push('user_id', $user->id);
            $result['session_id'] = Session::getId();
        }

        return response()->json($result);
    }

    // ログアウト
    public function logout(Request $request) {
        $user = Auth::user('manager');
        if (isset($user) && isset($user->id)) {
            Auth::guard('manager')->logout();
        }

        return response()->noContent();
    }

    // パスワード再登録メール送信
    public function sentPassword(SentPasswordRequest $request) {
        $response = 'password.failed';

        try {
            $email = request('email');
            $manager = Manager::where('email', $email)->first();

            if (empty($manager)) {
                $response = Password::INVALID_USER;
            } else {
                $token = app(PasswordBroker::class)->createToken($manager);
                $manager->email_token = $token;
                $manager->email_verified_at = date('Y-m-d H:i:s');
                $manager->save();

                $ret = MailManager::send_reset_password_to_manager($manager);
                if ($ret == true) {
                    $response = Password::RESET_LINK_SENT;
                }
            }
        } catch(\Exception $ex) {
            Log::error($ex->getMessage());
        }

        return response()->json($response);
    }

    // パスワード再登録
    public function resetPassword(ResetPasswordRequest $request) {
        try {
            $params = array(
                'email' => request('email'),
                'password' => request('password'),
            );
            $manager = Manager::where('email', $params['email'])->first();

            if (isset($manager)) {
                $manager->password = bcrypt($params['password']);
                $manager->email_token = null;
                $manager->email_verified_at = null;
                $manager->save();
            }
            else {
                return response()->json(1);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }

        return response()->json(0);
    }

    // パスワード再登録
    public function resetPasswordByOldPass(ResetPasswordByOldPassRequest $request) {
        try {
            $params = array(
                'old_password'  => request('old_password'),
                'password'      => request('password'),
            );

            $manager = Auth::user('manager');
            if (isset($manager) && password_verify($params['old_password'], $manager->password)) {
                $manager->password = bcrypt($params['password']);
                $manager->save();
            }
            else {
                return response()->json(1);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }

        return response()->json(0);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Manager::search($request->all())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagerRequest $request)
    {
        $validated = $request->validated();
        $managerInfo = [
            'email'           => $request->input('email'),
            'password'        => bcrypt($request->input('password')),
            'name'            => $request->input('name'),
            'authority'       => $request->input('authority', 1)
        ];
        $manager = Manager::create($managerInfo);
        $manager->save();
        return response()->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ManagerResource(Manager::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManagerRequest $request, $id)
    {
        $update = [
            'name'          => $request->input('name'),
            'email'         => $request->input('email'),
            'password'      => password_hash($request->input('password'), PASSWORD_DEFAULT),
            'authority'     => $request->input('authority', 1),
            'status'        => $request->input('status'),
            'memo'          => $request->input('memo'),
        ];
        if ($request->input('password') == '') {
            unset($update['password']);
        }
        Manager::where('id', $id)->update($update);
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Manager::where('id', $id)->delete();
        return response()->noContent();
    }

    // 管理者の停止
    public function halt($id) {
        $manager = Manager::findOrFail($id);
        $params = array (
            'status' => config('const.user.status.halting')
        );
        $manager->fill($params)->save();
        return response()->noContent();
    }

    // 管理者の再開
    public function restore($id) {
        $manager = Manager::findOrFail($id);
        $params = array (
            'status' => config('const.user.status.active')
        );
        $manager->fill($params)->save();
        return response()->noContent();
    }
}
