<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false)->comment("ユーザーID");
            $table->unsignedInteger('worker_id')->nullable(false)->comment("職人ID");
            $table->text('memo')->nullable(true)->comment("社内メモ");
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
        Schema::dropIfExists('charge_users');
    }
}
