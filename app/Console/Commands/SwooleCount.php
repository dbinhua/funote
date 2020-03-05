<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class SwooleCount extends Command
{
    protected $serv;

    const REAL_TIME_PAGES_COUNT_KEY = 'real_time_pages_count';    //当前打开页面数

    const REAL_TIME_USERS_COUNT_KEY = 'real_time_users_count';    //当前在线用户数

    const REAL_TIME_USERS_KEY = 'real_time_users';     //当前在线用户uids

    const PORT = 9502;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'manage real time count for swoole.';

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
        $this->start();
    }

    private function start()
    {
        //连接前清除redis相关缓存数据
        Redis::del(self::REAL_TIME_PAGES_COUNT_KEY);
        Redis::del(self::REAL_TIME_USERS_COUNT_KEY);
        Redis::del(self::REAL_TIME_USERS_KEY);

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
        $pushMsg = [
            'code' => 200,
            'fd' => $request->fd         //当前连接成功的客户端fd
        ];
        $serv->push($request->fd,json_encode($pushMsg));
    }

    private function onMessage($serv, $frame)
    {
        $frame_data = json_decode($frame->data);
        $redis_data = $this->getRealDataFromRedis();

        switch ($frame_data->type){
            case 1:
                $redis_data['real_time_pages_count'] ++;

                if ($frame_data->user_id){
                    if (!in_array($frame_data->user_id, $redis_data['real_time_users'])){
                        $redis_data['real_time_users_count'] ++;
                    }
                    $redis_data['real_time_users'][$frame_data->fd] = $frame_data->user_id;
                }else{
                    $redis_data['real_time_users_count'] ++;
                }

                Redis::set(self::REAL_TIME_PAGES_COUNT_KEY, $redis_data['real_time_pages_count']);
                Redis::set(self::REAL_TIME_USERS_COUNT_KEY, $redis_data['real_time_users_count']);
                Redis::set(self::REAL_TIME_USERS_KEY,json_encode($redis_data['real_time_users']));

                $pushMsg = [
                    'code' => 1,
                    'users_count' => $redis_data['real_time_users_count'],
                    'pages_count' => $redis_data['real_time_pages_count']
                ];

                foreach($serv->connections as $fd) {
                    $this->serv->push($fd, json_encode($pushMsg));
                }

                break;

            case 99: //心跳检测
                $this->info("收到来自{$frame->fd}的心跳检测，你安全了！");
                break;
            default:
                //code...
        }
    }

    private function onClose($serv, $fd)
    {
        $redis_data = $this->getRealDataFromRedis();
        $user_id = $redis_data['real_time_users'][$fd] ?? 0;

        if ($user_id){
            unset($redis_data['real_time_users'][$fd]);
        }

        if (!$user_id || !in_array($user_id, $redis_data['real_time_users'])){
            $redis_data['real_time_users_count'] > 0 && $redis_data['real_time_users_count'] --;
        }
        $redis_data['real_time_pages_count'] > 0 && $redis_data['real_time_pages_count'] --;

        Redis::set(self::REAL_TIME_PAGES_COUNT_KEY, $redis_data['real_time_pages_count']);
        Redis::set(self::REAL_TIME_USERS_COUNT_KEY, $redis_data['real_time_users_count']);
        Redis::set(self::REAL_TIME_USERS_KEY,json_encode($redis_data['real_time_users']));

        $pushMsg = [
            'code' => 1,
            'users_count' => $redis_data['real_time_users_count'],
            'pages_count' => $redis_data['real_time_pages_count']
        ];

        foreach($serv->connections as $fd_) {
            if ($fd_ == $fd) continue;
            $this->serv->push($fd_, json_encode($pushMsg));
        }
    }

    private function getRealDataFromRedis()
    {
        $data = [];
        $data['real_time_pages_count'] = Redis::get(self::REAL_TIME_PAGES_COUNT_KEY) ?? 0;
        $data['real_time_users_count'] = Redis::get(self::REAL_TIME_USERS_COUNT_KEY) ?? 0;
        $data['real_time_users'] = json_decode(Redis::get(self::REAL_TIME_USERS_KEY), true) ?? [];
        return $data;
    }
}
