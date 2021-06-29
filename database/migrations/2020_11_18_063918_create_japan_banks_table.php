<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJapanBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('japan_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false)->comment("ユーザーID");
            $table->integer('mark')->nullable(false)->comment("口座記号");
            $table->integer('number')->nullable(false)->comment("口座番号");
            $table->string('name', 191)->nullable(false)->comment("口座名義人");
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('japan_banks');
    }
}
