<?php

namespace App\Models\WeWork;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeWorkUser extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;
    public const SELECTED=1;
    public const NOT_SELECTED=0;
    public const ACTIVATED=1;
    public const STATUS_MAP = [
        self::ACTIVATED=>'已激活',
        2=>'已禁用',
        4=>'未激活',
        5=>'退出企业'
    ];

    protected $table = 'wework_users';
    protected $fillable = [
        'corp_id',
        'userid',
        'name',
        'avatar',
        'alias',
        'status',
        'open_user_id',
        'thumb_avatar',
        'status',
        'mobile',
        'email',
    ];

    public function scopeActivated(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('status', self::ACTIVATED);
    }

    public function scopeSelected(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('is_selected', self::SELECTED);
    }
}
