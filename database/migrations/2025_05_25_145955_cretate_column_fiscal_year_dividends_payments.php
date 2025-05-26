<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("dividends_payments", function (Blueprint $table) {
            $table->year("fiscal_year")->default(1901)->after("payment_date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("dividends_payments", function (Blueprint $table) {
            $table->dropColumn("fiscal_year");
        });
    }
};
