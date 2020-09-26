<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Work
 *
 * @property int $id
 * @property int|null $userid
 * @property int|null $type
 * @property int|null $work_start 上班时间
 * @property int|null $work_end 下班时间
 * @property float|null $work_time 工作时长
 * @property float|null $work_extra 加班时长
 * @property string|null $createDate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Work newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work query()
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWorkEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWorkExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWorkStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWorkTime($value)
 * @mixin \Eloquent
 */
class Work extends Base
{
    public $fillable = ['userid', 'work_start', 'work_end', 'work_time', 'work_extra', 'createDate'];
    /**
     * @var int
     */
}
