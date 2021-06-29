<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->unsignedInteger('manager_id')->nullable(false)->comment("管理者ID");
            $table->string('company', 255)->nullable(true)->comment("会社名");
            $table->string('tel', 20)->nullable(true)->comment("電話番号");
            $table->string('postal', 7)->nullable(true)->comment("郵便番号");
            $table->string('address', 255)->nullable(true)->comment("住所");
            $table->unsignedInteger('price')->nullable(true)->comment('契約金額');
            $table->unsignedTinyInteger('status')->nullable(false)->comment("ステータス");
            $table->unsignedTinyInteger('bank_type')->nullable(true)->comment("メインバンクタイプ");
            $table->unsignedInteger('bank_id')->nullable(true)->comment("メインバンクID");
            $table->text('manager_remark')->nullable(true)->comment("管理者備考");
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('email_token')->nullable()->comment('仮登録時に使用するトークン');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス認証日時');
            $table->string('password', 255)->nullable()->comment('パスワード');
            $table->tinyInteger('email_verified_flag')->default(0)->comment('情報認証');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
