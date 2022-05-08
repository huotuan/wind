<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wework_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wework_user_id')->default(0);
            $table->string('title', 128)->index('idx_corpId_title')->comment('标题');
            $table->string('digest', 128)->index('idx_digest')->comment('关键词');
            $table->text('content')->comment('回复内容');
            $table->boolean('status')->default(true)->comment('是否启用 1：是，0：否');
            $table->boolean('need_alarm')->default(false)->comment('是否报警 1：是，0：否');
            $table->integer('recall_time')->default(0)->comment('多久后撤回，0：不撤回，秒，最多24小时');
            $table->integer('interval_time')->default(0)->comment('消息的间隔，多久可以发送1次，小时');
            $table->string('url')->default('#');
            $table->string('msgtype')->nullable()->default('text')->comment('消息类型，具体参考企微文档');
            $table->dateTime('destroy_at')->nullable()->comment('销毁时间');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wework_replies');
    }
};
