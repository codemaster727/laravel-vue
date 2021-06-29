<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('work_id')->nullable(false)->comment("現場ID");
            $table->unsignedInteger('charge_id')->nullable(false)->comment("職人ID");
            $table->unsignedTinyInteger('charge_work_status')->nullable(true)->comment("職人ステータス");
            $table->date('work_date')->nullable(false)->comment("作業日");
            $table->time('work_start_on')->nullable(false)->comment("開始時間");
            $table->time('work_finish_on')->nullable(false)->comment("終了時間");
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
        Schema::dropIfExists('histories');
    }
}
