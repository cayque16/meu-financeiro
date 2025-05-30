<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
            $table->uuid("uuid")->nullable()->after("id");
        });

        $brokerages = DB::table("brokerages")->whereNull("uuid")->get();

        foreach ($brokerages as $brokerage) {
            DB::table("brokerages")
                ->where("id",$brokerage->id)
                ->update(["uuid" => Str::uuid()]);
        }

        Schema::table('brokerages', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("brokerages", function (Blueprint $table) {
            $table->dropColumn("uuid");
        });
    }
};
