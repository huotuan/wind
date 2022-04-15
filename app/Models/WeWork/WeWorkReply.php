<?php

namespace App\Models\WeWork;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function keywords()
    {
        return $this->hasMany(WeWorkKeywords::class, 'reply_id');
    }
}
