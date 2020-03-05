<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;
use App\Models\Emotion;

class SwooleChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:chat {action=start}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Manage websocket system for swoole";

    public $serv;

    const PORT = 9501;
    const PUB_GROUP_GUESTS = 'pub_group_guests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action){
            case 'start':
                $this->start();
                break;

            default:
                $this->error("Error: please input action[start|reload|stop]");
        }
    }

    private function start()
    {
        $this->serv = new \swoole_websocket_server("0.0.0.0",self::PORT);

        $this->serv->set([
            'daemonize' => App::environment(['production']) ? 1 : 0,  //只有生产环境设置进程守护
            'heartbeat_check_interval' => 45,
            'heartbeat_idle_time' => 60
        ]);

        //监听websocket连接打开事件
        $this->serv->on('open', function ($serv, $request) {
            $this->onOpen($serv, $request);
        });

        //监听websocket消息事件
        $this->serv->on('message', function ($serv, $frame) {
            $this->onMessage($serv, $frame);
        });

        //监听websocket连接关闭事件
        $this->serv->on('close', function ($request, $response) {
            $this->onClose($request, $response);
        });

        $this->serv->start();
    }

    private function onOpen($serv, $request)
    {
        //获取会话列表
        $chat_list = $this->getChatList();

        $pushMsg = [
            'code' => 200,
            'fd' => $request->fd,        //当前连接成功的客户端fd
            'chat_list' => $chat_list,   //会话列表
        ];

        $serv->push($request->fd,json_encode($pushMsg));
        $this->info("欢迎客户端 {$request->fd} 连接本服务器");
    }

    private function onMessage($serv, $frame)
    {
        $frame_data = json_decode($frame->data);

        switch ($frame_data->type){
            case 1:  //广播用户上线消息
                //更新已连接的客户端列表信息
                $pub_group_online_guests = Redis::get(self::PUB_GROUP_GUESTS);
                $guest_info = $pub_group_online_guests ? json_decode($pub_group_online_guests,true) : [];
                $guest_info[] = [
                    'fd' => $frame->fd,
                    'chat_id' => $frame_data->chat_id,
                    'user_id' => $frame_data->user_id ?? 0,
                    'name' => $frame_data->name ?? ''
                ];
                Redis::set(self::PUB_GROUP_GUESTS,json_encode($guest_info));

                //获取会话列表信息
                $chat_list = $this->getChatList();
                $pushMsg = [
                    'code' => 1,
                    'userinfo' => $frame_data,
                    'chat_list' => $chat_list
                ];

                foreach($serv->connections as $fd) {
                    $this->serv->push($fd, json_encode($pushMsg));
                }
                break;

            case 2:  //发送新消息
                $pushMsg = [
                    'code' => 2,
                    'msginfo' => $frame_data
                ];

                $emotions = $this->getEmotion();

                foreach ($emotions as $emotion_info){
                    //只有系统表情限制大小
                    if ($emotion_info->type == 1){
                        $dom = "<img src=\"{$emotion_info->path}\" style='width:24px;height:24px'>";
                    }else{
                        $dom = "<img src=\"{$emotion_info->path}\">";
                    }
                    $title = "[{$emotion_info->title}]";
                    $frame_data->newmessage = str_replace($title, $dom, $frame_data->newmessage);
                }

                $tmp = $this->remind($frame_data->newmessage);
                if($tmp){
                    $pushMsg['msginfo']->newmessage = $tmp['msg'];
                    $pushMsg['remains'] = $tmp['remains'] ?? [];
                }

                foreach($serv->connections as $fd) {
                    $pushMsg['msginfo']->time = date("H:i",time());
                    if($fd === $frame->fd){
                        $pushMsg['own'] = 1;
                    } else {
                        $pushMsg['own'] = 0;
                    }
                    $this->serv->push($fd, json_encode($pushMsg));
                }
                break;

            case 99: //心跳检测
                $this->info("收到来自客户端{$frame->fd}的心跳检测，你安全了！");
                break;
            default:
                //code...
        }
    }

    private function onClose($serv, $fd)
    {
        //删除已下线的用户
        $guests = Redis::get(self::PUB_GROUP_GUESTS);
        $pub_group_online_guests = $guests ? json_decode($guests,true) : [];

        foreach ($pub_group_online_guests as $key => $info){
            if ($info['fd'] == $fd){
                $close_user_info = $info;   //已经下线的用户信息
                unset($pub_group_online_guests[$key]);
            }
        }
        Redis::set(self::PUB_GROUP_GUESTS,json_encode(array_values($pub_group_online_guests)));

        //获取会话列表信息
        $chat_list = $this->getChatList();

        $pushMsg = [
            'code' => 3,
            'chat_list' => $chat_list
        ];

        //将用户下线信息推送给其他在线用户
        foreach ($pub_group_online_guests as $key => $info){
            if ($info['fd'] != $fd){
                $pushMsg['userinfo'] = $close_user_info ?? [];
                $serv->push($info['fd'],json_encode($pushMsg));
            }
        }
        $this->info("客户端 {$fd} 已关闭连接");
    }

    /**
     * 获取会话列表
     * @return array
     */
    private function getChatList()
    {
        $guests = Redis::get(self::PUB_GROUP_GUESTS);
        $online_person = $guests ? json_decode($guests,true) : [];

        return [
            ['id' => 1, 'title' => '服务大厅', 'type' => 2, 'group_bulletin' => '本群仅供游客体验，聊天记录无法同步，刷新页面或登录账号后记录将丢失，请您知晓哦～[了解更多]', 'group_members' => $online_person]
        ];
    }

    private function remind(string $msg)
    {
        $guests = Redis::get(self::PUB_GROUP_GUESTS);
        $online_person = $guests ? json_decode($guests,true) : [];

        $data = [];
        $data['msg'] = $msg;

        //正则匹配出所有@的人来
        if($msg && preg_match_all( '~@(.+?) ~',$msg,$matches)){

            $m1 = array_unique($matches[0]);
            $m2 = array_unique($matches[1]);

            foreach ($online_person as $online_user){
                $m3[$online_user['name']] = $online_user['fd'];
            }

            $i = 0;
            foreach($m2 as $_k => $_v){
                if(array_key_exists($_v,$m3)){
                    $data['msg'] = str_replace($m1[$_k],'<span style="color: #3498DB">'.trim($m1[$_k]).'</span>',$data['msg']);
                    $data['remains'][$i]['fd'] = $m3[$_v];
                    $data['remains'][$i]['name'] = $_v;
                    $i++;
                }
            }
            unset($users);
            unset($m1,$m2,$m3);
        }

        return $data;
    }

    private function getEmotion()
    {
        $emotion_model = new Emotion();
        return $emotion_model->getAll();
    }
}
