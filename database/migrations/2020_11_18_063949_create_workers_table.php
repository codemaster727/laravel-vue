<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('worker_code', 255)->nullable(false)->comment("職人登録用コード");
            $table->string('email', 255)->unique()->nullable(false)->comment("メールアドレス");
            $table->string('password', 60)->nullable(false)->comment("パスワード");
            $table->tinyInteger('status')->nullable(false)->default(0)->comment("ステータス  0：稼働、1：一時停止中");
            $table->string('name', 255)->nullable(false)->comment("名前");
            $table->text('manager_remark')->nullable(true)->comment("管理者備考");
            $table->string('remember_token', 100)->nullable(true)->comment("ログイン情報を記憶しておくcookie情報の一部");
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
        Schema::dropIfExists('workers');
    }
}
