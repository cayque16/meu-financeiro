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
        Schema::table("assets", function (Blueprint $table) {
            $table->uuid("uuid")->nullable()->after("id");
        });

        $assets = DB::table("assets")
            ->whereNull("uuid")
            ->get();

        foreach ($assets as $asset) {
            DB::table("assets")
                ->where("id", $asset->id)
                ->update(["uuid" => Str::uuid()]);
        }

        Schema::table('assets', function (Blueprint $table) {
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
        Schema::table("assets", function (Blueprint $table) {
            $table->dropColumn("uuid");
        });
    }
};
