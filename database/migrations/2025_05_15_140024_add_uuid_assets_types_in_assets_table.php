<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->uuid("uuid_assets_type")->nullable()->after("id_assets_type");
        });
        $types = DB::table('assets_types')->pluck('uuid', 'id');

        DB::table('assets')->orderBy('id')->chunk(100, function ($assets) use ($types) {
            foreach ($assets as $asset) {
                $uuid = $types[$asset->id_assets_type] ?? null;

                if ($uuid) {
                    DB::table('assets')
                        ->where('id', $asset->id)
                        ->update(['uuid_assets_type' => $uuid]);
                }
            }
        });
        Schema::table('assets', function (Blueprint $table) {
            $table->uuid('uuid_assets_type')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn("uuid_assets_type");
        });
    }
};
