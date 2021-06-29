<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargeWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('work_id')->nullable(false)->comment("現場ID");
            $table->unsignedInteger('worker_id')->nullable(false)->comment("職人ID");
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
        Schema::dropIfExists('charge_workers');
    }
}
