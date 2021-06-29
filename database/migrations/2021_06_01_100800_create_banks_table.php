<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('user_id')->constrained('users')->comment('ユーザーID');
            $table->string('type', 5)->comment('口座タイプ');
            $table->unsignedInteger('number')->comment('口座番号');
            $table->string('name', 255)->comment('口座名義人');
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
        Schema::dropIfExists('banks');
    }
}
