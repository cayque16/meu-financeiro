<?php

use Core\Domain\Enum\MovementType;
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
        Schema::create("movements", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->date("date");
            $table->uuid("brokerage_id")->index();
            $table->uuid("currency_id")->index();
            $table->enum("type", array_column(MovementType::cases(), 'value'))->index();
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
        Schema::dropIfExists('movements');
    }
};
