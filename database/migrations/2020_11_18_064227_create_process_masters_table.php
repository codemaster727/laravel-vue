<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false)->comment("ユーザーID");
            $table->string('name', 255)->nullable(false)->comment("工程名");
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
        Schema::dropIfExists('process_masters');
    }
}
