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
        Schema::create('wework_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('corp_id', 64)->comment('企业id');
            $table->string('userid', 64)->comment('成员id');
            $table->string('name', 50)->comment('成员名称');
            $table->string('avatar')->nullable()->comment('成员头像');
            $table->string('thumb_avatar')->nullable();
            $table->string('alias')->nullable()->comment('别名');
            $table->string('open_user_id')->nullable()->comment('open_user_id');
            $table->tinyInteger('status')->nullable()->default(1)->comment('激活状态: 1=已激活，2=已禁用，4=未激活，5=退出企业。');
            $table->string('email')->nullable();
            $table->string('mobile', 32)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index(['corp_id', 'userid'], 'idx_corpID_userId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wework_users');
    }
};
