<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false)->comment("ユーザーID");
            $table->unsignedTinyInteger('status')->nullable(false)->comment("現場ステータス");
            $table->string('name', 255)->nullable(false)->comment("現場名");
            $table->date('temporary_start_date')->nullable(true)->comment("仮押さえ開始日");
            $table->date('temporary_finish_date')->nullable(true)->comment("仮押さえ終了日");
            $table->date('period_start_date')->nullable(true)->comment("現場開始日");
            $table->date('period_finish_date')->nullable(true)->comment("現場終了日");
            $table->string('postal', 7)->nullable(true)->comment("現場郵便番号");
            $table->string('address', 255)->nullable(true)->comment("現場住所");
            $table->unsignedTinyInteger('client_id')->nullable(false)->comment("お客様ID");
            $table->unsignedTinyInteger('member_id')->nullable(false)->comment("営業担当ID");
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
        Schema::dropIfExists('works');
    }
}
