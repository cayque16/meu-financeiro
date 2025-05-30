<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table("brokerages", function (Blueprint $table) {
            $table->softDeletes();
        });
        
        DB::table("brokerages")
            ->where("e_excluido" , "=", 1)
            ->update(["deleted_at" => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("brokerages", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
