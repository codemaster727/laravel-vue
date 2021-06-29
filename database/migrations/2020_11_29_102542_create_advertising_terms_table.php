<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 広告期間のmigration
 */
class CreateAdvertisingTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('advertising_id')->nullable(false)->comment('広告会社ID');
            $table->string('token', 255)->nullable(true)->comment('トークン');
            $table->unsignedInteger('period')->nullable(false)->comment('契約期間');
            $table->timestamp('schedule_ended_at')->nullable(false)->comment('スケジュール終了予定日');
            $table->unsignedInteger('price')->nullable(false)->comment('契約金額');
            $table->timestamp('started_at')->nullable(true)->comment('開始日時');
            $table->timestamp('ended_at')->nullable(true)->comment('終了日時');
            $table->timestamp('approve_at')->nullable(true)->comment('承認日時');
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
        Schema::dropIfExists('advertising_terms');
    }
}
