<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2020/9/15 15:55
 * Email: zguangjian@outlook.com
 */

namespace App\Services;


class MessageService
{
    protected static $workType = [
        0 => "加班",
        1 => "上班打卡",
        2 => "下班打卡",
        3 => "加班",
        4 => "请假",
        5 => "调休",
        6 => "星期",
        7 => "节假日",
    ];

    protected static $userId;


    public static function send($message)
    {
        $user = UserService::getUserCache($message['FromUserName']);
        self::$userId = $user;
        return self::$message['MsgType']($message);
    }

    public static function event($message)
    {
        return '您好！欢迎使用 WorkClock';
    }

    public static function text($message)
    {
        return '收到文字消息';
    }

    public static function image($message)
    {
        return '收到图片消息';
    }

    public static function voice($message)
    {
        return '收到视频消息';
    }

    public static function video($message)
    {
        return '收到坐标消息';
    }

    public static function location($message)
    {
        return '收到坐标消息';
    }

    public static function link($message)
    {
        return '收到链接消息';
    }

    public static function file($message)
    {
        return '收到文件消息';
    }

    public static function shortvideo($message)
    {
        return '收到其它消息';
    }
}
