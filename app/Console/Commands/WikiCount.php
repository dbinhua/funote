<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class WikiCount extends Command
{
    protected $serv;

    const ONLINE_USERS_COUNT = 'wiki_online_users_count';    //当前在线用户数

    const PORT = 9602;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wiki:count';

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
        Redis::del(self::ONLINE_USERS_COUNT);

        $this->serv = new \swoole_websocket_server("0.0.0.0",self::PORT);

        $this->serv->set([
            'daemonize' => App::environment(['production']) ? 1 : 0,  //只有生产环境设置进程守护
            'heartbeat_check_interval' => 45,
            'heartbeat_idle_time' => 60
        ]);

        //监听websocket连接打开事件
        $this->serv->on('open', function ($serv, $request) {
            $this->onOpen($serv);
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

    private function onOpen($serv)
    {
        $redis_data = $this->getRealDataFromRedis();
        $redis_data[self::ONLINE_USERS_COUNT] ++;
        Redis::set(self::ONLINE_USERS_COUNT, $redis_data[self::ONLINE_USERS_COUNT]);

        $pushMsg = [
            'code' => 1,
            'onlineCount' => $redis_data[self::ONLINE_USERS_COUNT]
        ];

        foreach($serv->connections as $fd) {
            $this->serv->push($fd, json_encode($pushMsg));
        }
    }

    private function onMessage($serv, $frame)
    {
        $frame_data = json_decode($frame->data);

        switch ($frame_data->type){
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

        $redis_data[self::ONLINE_USERS_COUNT] > 0 && $redis_data[self::ONLINE_USERS_COUNT] --;
        Redis::set(self::ONLINE_USERS_COUNT, $redis_data[self::ONLINE_USERS_COUNT]);

        $pushMsg = [
            'code' => 1,
            'onlineCount' => $redis_data[self::ONLINE_USERS_COUNT]
        ];

        foreach($serv->connections as $fd_) {
            if ($fd_ == $fd) continue;
            $this->serv->push($fd_, json_encode($pushMsg));
        }
    }

    private function getRealDataFromRedis()
    {
        $data = [];
        $data[self::ONLINE_USERS_COUNT] = Redis::get(self::ONLINE_USERS_COUNT) ?? 0;
        return $data;
    }
}
