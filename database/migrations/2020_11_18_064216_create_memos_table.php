<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false)->comment("ユーザーID");
            $table->unsignedInteger('member_id')->nullable(false)->comment("営業担当者ID（作成者）");
            $table->string('title', 255)->nullable(true)->comment("タイトル");
            $table->text('text')->nullable(true)->comment("本文");
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
        Schema::dropIfExists('memos');
    }
}
