<?php

namespace App\Http\Controllers\Api\Manager;

use Log;
use Auth;
use Session;
use App\Models\User;
use App\Models\Manager;
use App\Mail\MailManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Requests\User\Auth\AuthRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\Manager\ManagerRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Auth\Passwords\PasswordBroker;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\SentPasswordRequest;
use App\Http\Resources\Manager\ManagerResource;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ResetPasswordByOldPassRequest;

class UserController extends ApiBaseController
{
    // 一覧取得
    public function index(Request $request)
    {
        $users = User::search($request->all())->get();
        return new UserCollection($users);
    }

    // ユーザーの取得
    public function show(User $user)
    {
        return new UserResource($user);
    }

    // ユーザーの追加
    // public function store(UserStoreRequest $request)
    public function store(Request $request)
    {
        $msg = '';
        // 自動メールを判別するトークンを取得します。
        $token = bin2hex(random_bytes(50));
        // $manager = Manager::where('name', request('manager'))->first();
        // 登録されたユーザの電子メールアドレスが既に存在するかチェックします。
        $old_user = User::where('email', request('email'))
                    ->first();
        if(isset($old_user)){
            $msg = 'dup_email';
        }else{
/*
            $params = array(
                'manager_id'    => request('manager_id'),
                'status'        => request('status', 0),
                'email'         => request('email'),
                'email_token'       => $token, // random value
                'email_verified_at'     => Carbon::now(), // value of current time
                // 'company'       => request('company'),
                // 'tel'           => request('tel'),
                // 'postal'        => request('postal', ''),
                // 'address'       => request('address', ''),
                // 'status'        => request('status', 0),
                // 'bank_type'     => request('bank_type', 0),
                // 'bank_id'       => request('bank_id', 0),
                // 'password'      => bcrypt(request('password', '')),
            );
            $user = User::create($params);
            $user->save();
*/
            // ユーザの電子メールアドレスを新たに登録します。
            date_default_timezone_set('Asia/Tokyo');
            $user = new User;
            $user->manager_id = request('manager_id');
            $user->email = request('email');
            $user->status = 0;
            $user->email_token = $token;
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();            
            // ユーザの電子メールアドレスにユーザ情報を入力するための自動電子メールを送信します。
            try {
                $ret = MailManager::send_register_user($user);
                if ($ret == true) {
                    $msg = 'ok';
                }
            } catch(Exception $ex) {
                $msg = 'mail failed';
            }
        }
        // 操作の結果を帰還します。
        return response()->json(['message' => $msg]);
    }

    // ユーザーの更新
    public function update(UserUpdateRequest $request, User $user)
    {
        $params = array(
            'manager_id'      => $user->manager_id,
            'company'         => request('company', $user->company),
            'tel'             => request('tel', $user->tel),
            'postal'          => request('postal', $user->postal),
            'address'         => request('address', $user->address),
            'status'          => request('status', $user->status),
            'bank_type'       => request('bank_type', $user->bank_type),
            'bank_id'         => request('bank_id', $user->bank_id),
            'email'           => request('email', $user->email),
            'manager_remark'  => request('manager_remark', $user->manager_remark),
            // 'password'      => $user->password,
        );
        // if (request('password') != '') {
        //     $params['password'] = bcrypt(request('password'));
        // }

        $user->fill($params)->save();

        return response()->noContent();
    }

    // ユーザーの削除
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    // ユーザーの停止
    public function halt($id) {
        $user = User::findOrFail($id);
        $params = array (
            'status' => config('const.user.status.halting')
        );
        $user->fill($params)->save();
        return response()->noContent();
    }

    // ユーザーの再開
    public function restore($id) {
        $user = User::findOrFail($id);
        $params = array (
            'status' => config('const.user.status.active')
        );
        $user->fill($params)->save();
        return response()->noContent();
    }
}
