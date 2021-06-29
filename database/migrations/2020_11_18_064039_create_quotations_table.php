<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id')->nullable(false)->comment("現場ID");
            $table->unsignedTinyInteger('status')->nullable(false)->default(0)->comment("確定情報");
            $table->string('name', 70)->nullable(false)->comment("件名");
            $table->string('number', 40)->nullable(false)->comment("見積書番号");
            $table->unsignedBigInteger('client_id')->nullable(false)->comment("お客様ID");
            $table->unsignedBigInteger('member_id')->nullable(false)->comment("営業担当ID");
            $table->date('publish_date')->nullable(true)->comment("発行日");
            $table->date('expiration_date')->nullable(true)->comment("有効期限");
            $table->unsignedInteger('total')->nullable(true)->comment("合計");
            $table->text('remark')->nullable(true)->comment("備考");
            $table->text('memo')->nullable(true)->comment("社内メモ");
            $table->timestamps();
            $table->softDeletes();

            //foreign keys
            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
