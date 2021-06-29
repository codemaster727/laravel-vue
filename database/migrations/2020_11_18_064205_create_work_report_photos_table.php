<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkReportPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_report_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('work_id')->nullable(false)->comment("作業ID");
            $table->string('photo', 255)->nullable(true)->comment("画像URL");
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
        Schema::dropIfExists('work_report_photos');
    }
}
