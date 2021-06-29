<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255)->unique()->nullable(false)->comment("管理者メールアドレス");
            $table->string('password', 255)->nullable(false)->comment("管理者パスワード");
            $table->string('name', 255)->nullable(false)->comment("管理者名");
            $table->unsignedTinyInteger('authority')->nullable(false)->default(1)->comment("権限の有無");
            // $table->string('remember_token')->nullable()->comment('パスワードリセット時に使用するトークン');
            $table->timestamp('email_verified_at')->nullable()->comment('パスワードリセットメール送信日時');
            $table->unsignedTinyInteger('status')->nullable(false)->default(0)->comment("ステータス");
            $table->text('memo')->nullable(true)->comment("社内メモ");
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers');
    }
}
