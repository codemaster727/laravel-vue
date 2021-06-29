<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('work_id')->nullable(false)->comment("現場ID");
            $table->unsignedInteger('process_color_id')->nullable(false)->comment("工程カラーID");
            $table->string('name', 255)->nullable(false)->comment("工程名");
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
        Schema::dropIfExists('processes');
    }
}
