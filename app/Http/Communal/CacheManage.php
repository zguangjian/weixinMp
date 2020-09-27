<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2020/9/27 17:07
 * Email: zguangjian@outlook.com
 */

namespace App\Http\Communal;

use App\Http\Communal\RedisManage;
use Exception;

/**
 * Class CacheManage
 * @package App\Http\Communal
 * @property RedisManage $redis
 * @method static Redis
 */
class CacheManage
{
    /**
     * @param $method
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($method, $params)
    {

        $app = new self();
        return $app->create($method);

    }

    /**
     * @param $method
     * @return mixed
     * @throws Exception
     */
    protected function create($method)
    {
        $methodClass = "App\\Http\\Communal\\" . ucfirst($method);
        if (class_exists($methodClass)) {
            return self::make($methodClass);
        }
        throw new Exception("Manage [{$method}] Not Exists");
    }

    /**
     * @param $method
     * @return mixed
     */
    public static function make($method)
    {
        return new $method();
    }
}
