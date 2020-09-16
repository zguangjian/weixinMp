<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2020/9/16 16:50
 * Email: zguangjian@outlook.com
 */

namespace App\Services;


use App\Model\Work;

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

    public static function word($type, $userid)
    {

        self::$userId = $userid;
        switch ($type) {
            case 0 :
                return 1;
                break;
            case 1 || 2:
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
            default;
        }
    }

    public static function punchClock($type)
    {
        $work = Work::where(['userid' => self::$userId, 'createDate' => date('Y-m-d')])->first();

        if ($type == 1) {
            if ($work) {
                return "今日上班已打卡";
            } else {
                Work::create([
                    'userid' => self::$userId,
                    'work_start' => time(),
                    'createDate' => date('Y-m-d')
                ]);
                return "上班打卡成功";
            }
        } else {
            if ($work) {
                $workHour = self::getWorkHour($work->work_start);
                $work->work_end = time();
                $work->work_time = $workHour >= self::$workHour ? self::$workHour : $workHour;
                $work->work_extra = $workHour >= self::$workHour ? $workHour - self::$workHour : 0;
                $work->save();
                return "下班打卡成功！今日工作" . $workHour . "小时，加班" . $work->work_extra . "小时";
            } else {
                //判断是否是昨日加班
                $work = Work::where(['userid' => self::$userId, 'createDate' => date('Y-m-d', strtotime('-1 day'))])->first();
                if ($work && $work->work_end == 0) {
                    $workHour = self::getWorkHour($work->work_start);
                    $work->work_end = time();
                    $work->work_time = $workHour >= self::$workHour ? self::$workHour : $workHour;
                    $work->work_extra = $workHour >= self::$workHour ? $workHour - self::$workHour : 0;
                    $work->save();
                    return "下班打卡成功！昨日工作" . $workHour . "小时，加班" . $work->work_extra . "小时";
                }
                return "请先打卡上班";
            }
        }
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return false|float|int
     */
    public static function getWorkHour($startTime, $endTime)
    {
        $hour = round(($endTime ?: time() - $startTime) / 60 / 60, 2);
        //12点之前打卡 则扣除午间休息
        if (date('H') < 12) {
            return $hour > self::$workHour ? $hour - self::$midday : $hour;
        } else {
            return $hour;
        }

    }
}