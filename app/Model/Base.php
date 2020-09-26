<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Base
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Base newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base query()
 * @mixin \Eloquent
 */
class Base extends Model
{
    //自动更新时间字段
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    //更新时间默认时间戳
    protected $dateFormat = 'U';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getTable()
    {
        return $this->table ? $this->table : strtolower(snake_case(class_basename($this)));
    }
}
