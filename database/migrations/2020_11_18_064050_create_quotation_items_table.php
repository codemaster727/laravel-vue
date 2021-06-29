<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id')->nullable(true)->comment("見積書ID");
            $table->string('name', 50)->nullable(false)->comment("品番・品名");
            $table->unsignedTinyInteger('quantity')->nullable(false)->comment("数量");
            $table->string('unit', 50)->nullable(false)->comment("単位");
            $table->integer('price')->nullable(false)->comment("単価");
            $table->integer('total')->nullable(false)->comment("合計");
            $table->unsignedInteger('sort_order')->nullable(false)->comment("並び順");
            $table->timestamps();
            $table->softDeletes();

            // foreign
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_items');
    }
}
