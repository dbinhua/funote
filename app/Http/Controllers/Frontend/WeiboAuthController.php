<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User\ThirdUserInfo;
use App\Models\User\UserInfo;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\User\ThirdUser;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WeiboAuthController extends Controller
{
    use AuthenticatesUsers;

    const AuthorizeApi = 'https://api.weibo.com/oauth2/authorize?';
    const AccessTokenApi = 'https://api.weibo.com/oauth2/access_token?';
    const UserInfoApi = 'https://api.weibo.com/2/users/show.json?';
    const ShareApi = 'https://api.weibo.com/2/statuses/share.json?';

    protected $client;
    protected $accessToken;
    protected $uid;
    protected $redirectUrl;

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client(['timeout' => 10.0]);
    }

    public function index(Request $request)
    {
        $param = [
            'client_id' => env('WEIBO_APP_KEY'),
            'response_type' => 'code',
            'redirect_uri' => route('weibo.rollback'),
            'state' => $request->input('refer') ?? ''
        ];
        $param = http_build_query($param);

        return redirect(self::AuthorizeApi.$param);
    }

    public function rollback(Request $request)
    {
        $res = $request->only('state','code');
        $this->redirectUrl = $res['state'] ?? route('index');
        $param = [
            'client_id' => env('WEIBO_APP_KEY'),
            'client_secret' => env('WEIBO_CLIENT_SECRET'),
            'grant_type' => 'authorization_code',
            'code' => $res['code'] ?? '',
            'redirect_uri' => $res['state'] ?? route('index')
        ];
        $param = http_build_query($param);

        $response = $this->client->post(self::AccessTokenApi.$param);
        if ($response->getStatusCode() == 200){
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $this->accessToken = $data->access_token;
            $this->uid = $data->uid;
            try {
                $this->createOrUpdateThirdUser();
            } catch (GuzzleException $e) {

            }
        }
        return redirect($this->redirectUrl);
    }

    /**
     * 写入或修改第三方登录用户信息
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createOrUpdateThirdUser()
    {
        $thirdUser = new ThirdUser();

        $param = [
            'access_token' => $this->accessToken,
            'uid' => $this->uid
        ];
        $param = http_build_query($param);

        try{
            $info = $this->client->get(self::UserInfoApi.$param);
            if ($info->getStatusCode() == 200){
                $info = $info->getBody()->getContents();
                $info = json_decode($info);

                $third_info = new ThirdUserInfo();
                $third_info->uid = $info->id;
                $third_info->type = ThirdUser::WEIBO;
                $third_info->nickname = $info->screen_name;
                $third_info->gender = $info->gender == 'm' ? 1 : ($info->gender == 'f' ? 2 : 0);
                $third_info->avatar = $info->profile_image_url;
                $third_info->avatar_large = $info->avatar_large;
                $third_info->access_token = $this->accessToken;
                $res = $thirdUser->createOrUpdateThirdUser($this->filterObjectNullAttr($third_info));
                if ($res && $bind_id = $this->bindAccount($third_info)){
                    Auth::loginUsingId($bind_id, true);
                }
            }
        }catch (\Exception $exception){
            return redirect($this->redirectUrl);
        }
    }

    /**
     * @param ThirdUserInfo $third_info
     * @return int
     */
    public function bindAccount(ThirdUserInfo $third_info):int
    {
        $thirdUser = new ThirdUser();
        $fresh_info = $thirdUser->getInfo($third_info->uid, $third_info->type);
        if (!($fresh_info->bind_id ?? null)){
            $info = new UserInfo();
            $info->name = $third_info->nickname;
            $info->password = Hash::make('123456');
            $info->avatar = $third_info->avatar_large;
            $info->gender = $third_info->gender;

            $user = new User();
            $insert_id = $user->createUserReturnId($this->filterObjectNullAttr($info));

            $insert_id && $third_info->bind_id = $insert_id;
            $thirdUser->createOrUpdateThirdUser($this->filterObjectNullAttr($third_info));
            return $insert_id;
        }
        return $fresh_info->bind_id;
    }

//    public function share()
//    {
//        $thirdUserInfo = ThirdUser::getOne(['id' => Auth::user()->third_auth_id]);
//
//        $param = [
//            'access_token' => $thirdUserInfo->access_token,
//            'status' => 'Fun Note开通啦！欢迎大家造访～ https://funote.cn'
//        ];
//
//        try{
//            $this->client->request('POST', self::ShareApi, ['form_params' => $param]);
//
//        }catch (\Exception $exception){
//
//        }
//        return redirect()->route('index');
//    }
}
