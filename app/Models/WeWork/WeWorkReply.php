<?php

namespace App\Models\WeWork;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeWorkReply extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;
    public const ACTIVED =1;
    protected $table = 'wework_replies';
    protected $fillable = ['corp_id', 'wework_user_id', 'title', 'content', 'status', 'need_alarm', 'recall_time', 'interval_time', 'url', 'destroy_at'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(WeWorkUser::class, 'wework_user_id');
    }

    public function digest(): Attribute
    {
        return new Attribute(
            get: fn ($value) => blank($value) ? $value : explode('--', $value),
            set: fn ($value) => blank($value) ? $value : implode('--', $value),
        );
    }
}
