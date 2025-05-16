<?php

use Core\Domain\Enum\DividendType;
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
        Schema::create('dividends_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('asset_id')->index();
            $table->date('date');
            $table->enum('type', array_column(DividendType::cases(), 'value'))->index();
            $table->integer('amount');
            $table->uuid('currency_id')->index();
            $table->softDeletes();
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
        Schema::dropIfExists('dividends_payments');
    }
};
