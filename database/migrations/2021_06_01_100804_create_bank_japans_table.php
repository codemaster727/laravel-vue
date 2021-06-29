<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankJapansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_japans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->comment('銀行ID')->constrained('banks');
            $table->unsignedInteger('mark')->comment('口座記号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_japans');
    }
}
