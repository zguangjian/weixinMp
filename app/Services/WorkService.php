<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2020/9/16 16:50
 * Email: zguangjian@outlook.com
 */

namespace App\Services;


use App\Http\Communal\RedisManage;
use App\Model\Work;
use phpDocumentor\Reflection\Types\Self_;
use TheSeer\Tokenizer\Exception;

class WorkService
{
    /**
     * @var
     */
    protected static $userId;

    /**
     * 工作时长
     * @var int
     */
    public static $workHour = 7;

    /**
     * 午休 2小时
     * @var int
     */
    protected static $midday = 2;

    /**
     * 起始打卡时间不能
     * @var int
     */
    protected static $startHour = 7;

    /**
     * @param $type
     * @param $userid
     * @return int|string
     */
    public static function word($type, $userid)
    {
        self::$userId = $userid;
        switch ($type) {
            case 0 :
                return 1;
                break;
            case $type == 1 || $type == 2:
                return self::punchClock($type);
                break;
            case 3 :
                echo 3;
                break;
            case 4 :
                echo 4;
                break;
            case 5 :
                echo 5;
                break;
            case 6 :
                echo 6;
                break;
            case 7 :
                echo 7;
                break;
            case 8 :
                echo 8;
                break;
            case 10:
                return self::workList();
                break;
            default;
        }
    }

    public static function workList()
    {
        return "点击进入<a href='" . url('/user', ['userid' => self::$userId]) . "'>个人中心</a>查看";
    }

    /**
     * @param $type
     * @return string
     */
    public static function punchClock($type)
    {
        if ($type == 1) {
            if (RedisManage::Work()->getHashData(self::$userId) == date('Y-m-d')) {
                return "今日上班已打卡";
            } else {
                if (date('H') < self::$startHour) {
                    return sprintf("最早%s点开始打卡.", self::$startHour);
                }
                Work::create([
                    'userid' => self::$userId,
                    'work_start' => time(),
                    'createDate' => date('Y-m-d')
                ]);
                RedisManage::Work()->setHashData(self::$userId, date('Y-m-d'));
                return "上班打卡成功,打卡时间为" . date('Y-m-d H:i:s');
            }
        } else {
            $work = Work::where(['userid' => self::$userId])->orderBy('id', 'desc')->first();
            try {
                if ($work && $work->createDate == date('Y-m-d')) {
                    $work = Work::where(['userid' => self::$userId, 'createDate' => date('Y-m-d')])->first();
                    $workHour = self::getWorkHour($work->work_start);
                    $work->work_end = time();
                    $work->work_time = $workHour >= self::$workHour ? self::$workHour : $workHour;
                    $work->work_extra = $workHour >= self::$workHour ? $workHour - self::$workHour : 0;
                    $work->save();
                    return "下班打卡成功！今日工作" . $workHour . "小时，加班" . $work->work_extra . "小时";
                } else if ($work->createDate == date('Y-m-d', strtotime("-1 day"))) {
                    //判断是否是昨日加班
                    if ($work ) {
                        $workHour = self::getWorkHour($work->work_start);
                        $work->work_end = time();
                        $work->work_time = $workHour >= self::$workHour ? self::$workHour : $workHour;
                        $work->work_extra = $workHour >= self::$workHour ? $workHour - self::$workHour : 0;
                        $work->save();
                        return "下班打卡成功！昨日工作" . $workHour . "小时，加班" . $work->work_extra . "小时";
                    }
                } else {
                    return "请先打卡上班";
                }

            } catch (\Exception $exception) {
                return $exception->getMessage();
            }

        }
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return false|float|int
     */
    public static function getWorkHour($startTime, $endTime = "")
    {
        $hour = round((($endTime ?: time()) - $startTime) / 60 / 60, 2);
        //12点之前打卡 则扣除午间休息
        if (date('H', $startTime) < 12 && date('H', $startTime) >= self::$startHour) {
            return $hour > self::$workHour ? round($hour - self::$midday, 2) : round($hour, 2);
        } else {
            return $hour;
        }

    }
}
