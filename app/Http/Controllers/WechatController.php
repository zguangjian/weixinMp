<?php

namespace App\Http\Controllers;

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
        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key" => "V1001_TODAY_MUSIC"
            ],
            [
                "name" => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url" => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url" => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];
        $app = Factory::officialAccount($this->config);


        return $app->menu->create($buttons);
    }
}
