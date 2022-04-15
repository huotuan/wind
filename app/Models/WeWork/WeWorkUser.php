<?php

namespace App\Models\WeWork;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeWorkUser extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;
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
}
