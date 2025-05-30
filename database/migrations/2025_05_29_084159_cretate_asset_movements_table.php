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
        Schema::create("asset_movements", function (Blueprint $table) {
            $table->uuid("movement_id");
            $table->uuid("asset_id");
            $table->integer("amount");
            $table->integer("unit_value");
            $table->integer("value_fees");
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
        Schema::dropIfExists("asset_movements");
    }
};
