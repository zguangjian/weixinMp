<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use EasyWeChat\Factory;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function serve(Request $request)
    {
        $config = [
            'app_id' => 'wx0218e6301a1ac978',
            'secret' => 'bfc599df4b060f205471b15edbfe7ae2',
            'token' => 'weixin',
            'response_type' => 'array',
        ];
        $app = Factory::officialAccount($config);
        $app->server->push(function ($message) use ($app) {
            return MessageService::send($message);
        });

        return $app->server->serve();
    }
}
