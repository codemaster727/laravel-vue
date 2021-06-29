<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkReportItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_report_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('work_report_id')->nullable(false)->comment("作業報告書ID");
            $table->unsignedInteger('work_id')->nullable(false)->comment("現場ID");
            $table->string('photo', 255)->nullable(true)->comment("写真URL");
            $table->string('name', 255)->nullable(false)->comment("項目名");
            $table->date('work_date')->nullable(true)->comment("日付");
            $table->string('photographer', 255)->nullable(true)->comment("撮影者名");
            $table->text('content')->nullable(true)->comment("撮影内容");
            $table->text('remark')->nullable(true)->comment("備考（共有メモ）");
            $table->text('memo')->nullable(true)->comment("社内メモ");
            $table->unsignedInteger('order')->nullable(false)->comment("並び順");
            $table->unsignedTinyInteger('pdf')->nullable(false)->comment("PDF用");
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
        Schema::dropIfExists('work_report_items');
    }
}
