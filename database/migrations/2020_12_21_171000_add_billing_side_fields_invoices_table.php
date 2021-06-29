<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingSideFieldsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('bill_company_name', 12)->comment('見積元：自社名')->after('memo');
            $table->string('bill_postal', 12)->comment('見積元：郵便番号')->after('bill_company_name');
            $table->string('bill_address', 128)->comment('見積元：住所')->after('bill_postal');
            $table->string('bill_tel', 16)->comment('見積元：TEL')->after('bill_address');
            $table->string('bill_email', 128)->comment('見積元：メールアドレス')->after('bill_tel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['bill_company_name', 'bill_postal', 'bill_address', 'bill_tel', 'bill_email']);
        });
    }
}
