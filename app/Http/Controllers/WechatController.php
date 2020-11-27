<?php

namespace App\Http\Controllers;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\OfficialAccount\Application;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request as RequestAlias;
use ReflectionException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class WechatController extends Controller
{

    //扩展包 composer require overtrue/wechat:~4.0 -vvv
    protected $config = [
        'app_id' => 'wxf7e2ebb0049f0af7',
        'secret' => '4ed2e7b47138cd6f762f996f57fbbdf6',
        'token' => 'weixin',
        'response_type' => 'array',
        'oauth' => [
            'scopes' => ['snsapi_userinfo'],
            'callback' => '/oauth_callback',
        ],
    ];
    /**
     * @var Application
     */
    protected $app;

    public function __construct()
    {
        $this->app = Factory::officialAccount($this->config);
    }

    /**
     * 绑定连接 消息回复
     * @return Response|void
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws ReflectionException
     */
    public function connect()
    {
        //配置连接
        //return $this->app->server->serve();
        //推送消息
        $this->app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }

            // ...
        });
        return $this->app->server->serve();

    }

    /**
     * 设置菜单
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function menu()
    {
        //删除菜单
        //$this->app->menu->delete();
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
                        "type" => "view",
                        "name" => "授权登录",
                        "url" => route('oauth')
                    ],
                ],
            ],
        ];
        $this->app->menu->create($buttons);
    }

    /**
     * 二维码
     */
    public function qrcode()
    {
        $result = $this->app->qrcode->temporary("foo", 6 * 24 * 3600);
        dd($result);
    }

    /**
     * 网页授权
     * @return RedirectResponse
     */
    public function oauth()
    {
        return $this->app->oauth->redirect();
    }

    /**
     * 回调地址
     * @param RequestAlias $request
     */
    public function oauthCallback(RequestAlias $request)
    {
        $user = $this->app->oauth->user();
        dd($user);
    }

    /**
     * 短链接
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function shorten()
    {
        $result = $this->app->url->shorten("www.guangjian.site");
        dd($result);
    }


}
