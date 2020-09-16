<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2020/9/15 16:33
 * Email: zguangjian@outlook.com
 */

namespace App\Services;


use App\Model\User;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

class UserService
{
    /**
     * @param $openid
     * @return string
     */
    public static function getCacheKey($openid)
    {
        return env('APP_NAME') . '__' . $openid;
    }

    /**
     * @param $openid
     * @return bool
     */
    public static function getUserCache($openid)
    {
        if (Cache::has(self::getCacheKey($openid))) {
            return Cache::get(self::getCacheKey($openid));
        } else {
            self::setUserCache($openid);
            return self::getUserCache($openid);
        }
    }

    /**
     * @param $openid
     * @return bool
     */
    public static function setUserCache($openid)
    {
        $user = User::where('openid', $openid)->first();

        if (empty($user)) {
            $user = User::create(['openid' => $openid]);
        }
        dd(Cache::forever(self::getCacheKey($openid), $user->id));
        return true;
    }

    public static function clearUserCache($openid)
    {
        return Cache::decrement(self::getCacheKey($openid));
    }
}
