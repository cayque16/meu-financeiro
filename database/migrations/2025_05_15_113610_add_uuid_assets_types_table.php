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
        Schema::table("assets_types", function (Blueprint $table) {
            $table->uuid("uuid")->nullable()->after("id");
        });
        
        $types = DB::table("assets_types")
            ->whereNull("uuid")
            ->get();

        foreach ($types as $type) {
            DB::table("assets_types")
                ->where("id", $type->id)
                ->update(["uuid" => Str::uuid()]);
        }

        Schema::table('assets_types', function (Blueprint $table) {
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
        Schema::table("assets_types", function (Blueprint $table) {
            $table->dropColumn("uuid");
        });
    }
};
