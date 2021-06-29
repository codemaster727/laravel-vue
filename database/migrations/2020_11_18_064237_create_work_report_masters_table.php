<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkReportMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_report_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false)->comment("ユーザーID");
            $table->string('name', 255)->nullable(false)->comment("撮影項目名");
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
        Schema::dropIfExists('work_report_masters');
    }
}
