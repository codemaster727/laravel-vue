<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * 広告のmigration
 */
class CreateAdvertisingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('manager_id')->nullable(false)->comment('管理者ID');
            $table->unsignedTinyInteger('status')->nullable(false)->default(config('const.advertisings.status.active'))->comment('ステータス');
            $table->string('company', 255)->nullable(true)->comment('会社名');
            $table->string('url', 255)->nullable(true)->comment('URL');
            $table->string('img_url', 255)->nullable(true)->comment('画像URL');
            $table->string('charge', 255)->nullable(true)->comment('担当者名');
            $table->string('email', 255)->nullable(true)->comment('担当者メールアドレス');
            $table->string('phone', 16)->nullable(true)->comment('担当者電話番号');
            $table->string('mobile', 16)->nullable(true)->comment('担当者携帯番号');
            $table->string('zip', 255)->nullable(true)->comment('郵便番号');
            $table->string('address', 255)->nullable(true)->comment('住所');
            $table->text('manager_remark')->nullable(true)->comment('管理者備考');
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
        Schema::dropIfExists('advertisings');
    }
}
