<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Helpers\AliSms;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CaptchaController extends Controller
{
    use AliSms;

    const CAPTCHA_PREFIX = 'CAPTCHA_';

    public function sendCaptcha(Request $request)
    {
        if (!$request->has('phoneNumbers')){
            return $this->failed('手机号不能为空', 415);
        }

        if (preg_match('/^1[3456789]\d{9}$/', $request->phoneNumbers) === 0){
            return $this->failed('手机号格式错误', 400);
        }

        $redisCaptcha = Redis::get(self::CAPTCHA_PREFIX.$request->phoneNumbers);
        $redisCaptcha = json_decode($redisCaptcha);
        if ($redisCaptcha && (time() - $redisCaptcha->created_at < 120)){
            return $this->failed('请求过于频繁，请2分钟后再试', 400);
        }

        //生成验证码
        $captcha = '';
        for ($i = 0; $i < 6; $i ++){
            $captcha .= random_int(0, 9);
        }
        $captchaInfo = ['captcha' => $captcha, 'created_at' => time()];
        $setCaptcha = Redis::setex(self::CAPTCHA_PREFIX.$request->phoneNumbers, 600, json_encode($captchaInfo));
        if ((string)$setCaptcha === 'OK'){
            $this->sendSms($request->phoneNumbers, ['code' => $captcha]);
            return $this->success();
        }
        return $this->failed('验证码发送失败');
    }
}
