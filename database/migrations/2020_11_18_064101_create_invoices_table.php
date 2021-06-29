<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id')->nullable(false)->comment("現場ID");
            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade');
            $table->unsignedBigInteger('quotation_id')->nullable(true)->comment("見積書ID");
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
            $table->string('name', 70)->nullable(false)->comment("件名");
            $table->string('invoice_number', 40)->nullable(false)->comment("請求書番号");
            $table->unsignedBigInteger('client_id')->nullable(false)->comment("お客様ID");
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('member_id')->nullable(false)->comment("営業担当ID");
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->date('publish_date')->nullable(true)->comment("発行日");
            $table->date('limit_date')->nullable(true)->comment("お支払い期限");
            $table->unsignedInteger('total')->nullable(true)->comment("合計");
            $table->text('remark')->nullable(true)->comment("備考");
            $table->text('memo')->nullable(true)->comment("社内メモ");
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
        Schema::dropIfExists('invoices');
    }
}
