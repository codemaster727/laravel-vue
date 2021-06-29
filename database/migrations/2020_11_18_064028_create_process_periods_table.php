<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('process_id')->nullable(false)->comment("工程ID");
            $table->date('start_date')->nullable(true)->comment("開始日");
            $table->date('finish_date')->nullable(true)->comment("終了日");
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
        Schema::dropIfExists('process_periods');
    }
}
