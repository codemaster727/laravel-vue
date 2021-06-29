<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('work_id')->nullable(false)->comment("現場ID");
            $table->string('title', 255)->nullable(false)->comment("タイトル");
            $table->string('logo', 255)->nullable(true)->comment("ロゴURL");
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
        Schema::dropIfExists('work_reports');
    }
}
