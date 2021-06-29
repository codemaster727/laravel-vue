<?php

namespace App\Http\Controllers\Api\User;

use Log;
use Auth;
use Session;
use App\Mail\MailManager;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Manager;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\SentPasswordRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\PasswordBroker;
use App\Http\Requests\User\Auth\AuthRequest;
use App\Http\Requests\User\ResetPasswordByOldPassRequest;
use App\Http\Requests\User\UpdateBankRequest;
use DB;

class UserController extends ApiBaseController
{
    /**
     * Instantiate a new controller instance
     * @return void
     */
    public function __construct()
    {
    }

    // ユーザーリストの取得
    public function index() {
        $key = request('key');
        $sortBy = request('sort_by', 'created_at');
        $order =  request('order', 'desc');
        $perPage = request('per_page', 10);
        $currentPage = request('current_page', 1);
        $status = request()->query('status');

        $user = new User();
        $query = $user->filterByKey($key);

        return new UserCollection($query->orderBy($sortBy, $order)
            ->paginate($perPage, ['*'], 'current_page'));
    }

    // ユーザーの取得
    public function show(User $user) {
        return new UserResource($user);
    }

    // ユーザ情報の入力
    public function input_info(UserStoreRequest $request) {
        $msg = 'fail';
        $params = array(
            'password'      => bcrypt(request('password', '')),
            'tel'           => request('tel', ''),
            'company'       => request('company', ''),
            'postal'        => request('postal', ''),
            'address'       => request('address', ''),
            'email_verified_flag' => '1'
        );

        // 管理者の登録から8時間前である場合、ユーザ情報を登録する。
        date_default_timezone_set('Asia/Tokyo');
        $time_before_8hours = date('Y-m-d H:i:s', strtotime('-8 hour'));
        $user = User::where('email_token', request('token'))
                    ->where('email_verified_at', '>=', $time_before_8hours)
                    ->first();

        if(isset($user)){
            if($user->fill($params)->save()){
                $msg = 'ok';
            }
        }else{
            $msg = 'not_user';
        }

        // 8時間が過ぎても登録されていないユーザを削除する。
        DB::delete("DELETE FROM users WHERE email_verified_at < '".$time_before_8hours."' and email_verified_flag = 0");
/*        
        $res = User::where('email_verified_flag', '0')
            ->where('email_verified_at', '<', $time_before_8hours)
            ->delete();
*/            
        // 操作の結果を帰還する。

        return response()->json(['message' => $msg]);
    }

        // ユーザーの追加
    public function store(UserStoreRequest $request) {
        $manager = Manager::where('name', request('manager'))->first();

        $params = array(
            'manager_id'    => $manager->id,
            'company'       => request('company'),
            'tel'           => request('tel'),
            'postal'        => request('postal', ''),
            'address'       => request('address', ''),
            'status'        => request('status', 0),
            'bank_type'     => request('bank_type', 0),
            'bank_id'       => request('bank_id', 0),
            'email'         => request('email'),
            'password'      => bcrypt(request('password', '')),
        );

        $user = User::create($params);
        $user->save();

        return response()->noContent();
    }
    
    // ユーザーの更新
    public function update(Request $request, User $user) {
        $params = array(
            'manager_id'    => $user->manager_id,
            'company'       => request('company', $user->company),
            'tel'           => request('tel', $user->tel),
            'postal'        => request('postal', $user->postal),
            'address'       => request('address', $user->address),
            'status'        => request('status', $user->status),
            'bank_type'     => request('bank_type', $user->bank_type),
            'bank_id'       => request('bank_id', $user->bank_id),
            'email'         => request('email', $user->email),
            'password'      => $user->password,
        );
        $manager = Manager::where('id', request('manager_id'))->first();
        if (isset($manager)) {
            $params['manager_id'] = $manager->id;
        }
        if (request('password') != '') {
            $params['password'] = bcrypt(request('password'));
        }

        $user->fill($params)->save();

        return response()->noContent();
    }

    // ユーザーの削除
    public function destroy(User $user) {
        $user->delete();

        return response()->noContent();
    }

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

        $user = User::where('email', $params['email'])->first();
        if (isset($user) && password_verify($params['password'], $user->password)) {
            $user = Auth::guard('web')->loginUsingId($user->id, $params['remember_token']);
            Session::push('user_id', $user->id);
            $result['session_id'] = Session::getId();
        }

        return response()->json($result);
    }

    // ログアウト
    public function logout(Request $request) {
        $user = Auth::user();
        if (isset($user) && isset($user->id)) {
            Auth::guard('web')->logout();
        }

        return response()->noContent();
    }

    // パスワード再登録メール送信
    public function sentPassword(SentPasswordRequest $request) {
        $response = 'password.failed';

        try {
            $email = request('email');
            $user = User::where('email', $email)->first();

            if (empty($user)) {
                $response = Password::INVALID_USER;
            } else {
                $token = app(PasswordBroker::class)->createToken($user);
                $user->email_token = $token;
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();

                $ret = MailManager::send_reset_password($user);
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

            $user = User::where('email', $params['email'])->first();

            if (isset($user)) {
                $user->password = bcrypt($params['password']);
                $user->save();
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

            $user = Auth::user();
            if (isset($user) && password_verify($params['old_password'], $user->password)) {
                $user->password = bcrypt($params['password']);
                $user->save();
            }
            else {
                return response()->json(1);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }

        return response()->json(0);
    }

    public function updateBank(UpdateBankRequest $request) {
        try {
            $user = Auth::user();

            $user->bank_type = request('bank_type');
            $user->bank_id = request('bank_id');

            $user->save();
            return response()->json(0);
        }
        catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(1);
        }
    }
}
