<?php

use App\Models\Asset;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Asset::whereNull('uuid')->withTrashed()->chunk(100, function ($types) {
            foreach ($types as $type) {
                $type->uuid = Str::uuid();
                $type->save();
            }
        });
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
