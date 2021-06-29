<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnoseReportItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnose_report_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagnose_report_id')->nullable(true)->comment("診断報告書ID");
            $table->string('photo', 255)->nullable(true)->comment("写真URL");
            $table->string('name', 255)->nullable(true)->comment("項目名");
            $table->string('content', 255)->nullable(true)->comment("撮影内容");
            $table->unsignedInteger('sort_order')->nullable(true)->comment("並び順");
            $table->timestamps();
            $table->softDeletes();

            // foreign
            $table->foreign('diagnose_report_id')->references('id')->on('diagnose_reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnose_report_items');
    }
}
