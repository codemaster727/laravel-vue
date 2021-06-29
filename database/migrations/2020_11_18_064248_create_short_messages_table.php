<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ショートメッセージのmigration
 */
class CreateShortMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->nullable(false)->comment('メッセージ種別');
            $table->unsignedInteger('user_id')->nullable(false)->comment('ユーザーID');
            $table->unsignedInteger('work_id')->nullable(false)->comment('現場ID');
            $table->unsignedInteger('client_id')->nullable(false)->comment('お客様ID');
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
        Schema::dropIfExists('short_messages');
    }
}
