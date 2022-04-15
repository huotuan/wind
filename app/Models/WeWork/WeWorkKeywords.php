<?php

namespace App\Models\WeWork;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeWorkKeywords extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'wework_reply_keywords';
    protected $fillable = ['wechat_user_id', 'reply_id', 'keywords'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(WeWorkUser::class, 'wework_user_id');
    }

    public function reply(): BelongsTo
    {
        return $this->belongsTo(WeWorkReply::class, 'reply_id');
    }
}
