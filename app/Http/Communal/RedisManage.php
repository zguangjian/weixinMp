<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2020/9/27 17:05
 * Email: zguangjian@outlook.com
 */

namespace App\Http\Communal;

use Illuminate\Support\Facades\Redis;

/**
 * Class RedisManage
 * @package App\Http\Communal
 * @method static Work
 */
class RedisManage
{
    public $method;

    public static function __callStatic($method, $param)
    {
        return new self($method, $param);

    }

    public function __construct($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getHashDataKey()
    {
        return "Redis__Hash__" . $this->method;
    }

    /**
     * @param $userid
     * @return mixed
     */
    public function getHashData($userid)
    {
        return Redis::hget($this->getHashDataKey(), $userid);
    }

    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function setHashData($key, $data)
    {
        return Redis::hset($this->getHashDataKey(), $key, $data);
    }

    /**
     *
     */
    public function clearHashData()
    {
        return Redis::hdel(self::getHashDataKey());
    }
}
