<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false)->comment("ユーザーID");
            $table->string('financial_name', 191)->nullable(false)->comment("金融機関名");
            $table->string('branch_name', 191)->nullable(false)->comment("支店名");
            $table->string('branch_number', 191)->nullable(false)->comment("支店番号");
            $table->unsignedTinyInteger('type')->nullable(false)->default(0)->comment("口座種別");
            $table->string('number', 7)->nullable(false)->comment("口座番号");
            $table->string('name', 191)->nullable(false)->comment("口座名義人");
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
        Schema::dropIfExists('other_banks');
    }
}
