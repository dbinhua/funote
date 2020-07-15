<?php

namespace App\Http\Controllers\Api\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends FrontendAPIController
{
    /*
     * 用户注册
     */
    public function signup(Request $request)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        try{
            $user->save();
        }catch (\Exception $exception){
            return $this->failed('该邮箱已被注册！', 403);
        }

        return $this->success();
    }

    /*
     * 用户登录
     */
    function login(LoginRequest $request){
        $res = Auth::attempt($request->only(['email','password']));
        if($res){
            $user = $request->user();
            $tokenRes = $user->createToken('accessToken');
            $token = $tokenRes->token;
            $token->save();

            $token = $tokenRes->accessToken;
            $uid = Auth::user()->id;

            $response = compact('token','uid');
            return $this->success($response);
        }
        return $this->failed('账号不存在或密码错误');
    }

    /*
     * 用户登出
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->success();
    }
}
