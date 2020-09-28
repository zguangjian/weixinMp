<?php

namespace App\Http\Controllers;

use App\Http\Communal\CacheManage;
use App\Http\Communal\RedisManage;
use App\Services\MessageService;
use EasyWeChat\Factory;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    protected $config = [
        'app_id' => 'wx0218e6301a1ac978',
        'secret' => 'bfc599df4b060f205471b15edbfe7ae2',
        'token' => 'weixin',
        'response_type' => 'array',
    ];

    public function serve(Request $request)
    {

        $app = Factory::officialAccount($this->config);
        $app->server->push(function ($message) use ($app) {
            return MessageService::send($message);
        });

        return $app->server->serve();
    }

    public function user()
    {

        $str = "{\"ToUserName\":\"gh_6927c252a950\",\"FromUserName\":\"oMTnz52O9IDZ6cyziKV2jeWZjEsY\",\"CreateTime\":\"1600157123\",\"MsgType\":\"text\",\"Content\":\"上班打卡\",\"MsgId\":\"22908745661902076\"}";
        $message = json_decode($str, true);
        return MessageService::send($message);
    }
}
