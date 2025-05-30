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
        Schema::create('assets_tmp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('code', 10);
            $table->char('description', 100);
            $table->uuid('assets_type_id');
            $table->timestamps();
            $table->softDeletes();
        });

        $assets = DB::table('assets')->get();
        
        foreach ($assets as $asset) {
            DB::table('assets_tmp')->insert([
                'id' => $asset->id,
                'code' => $asset->codigo,
                'description' => $asset->descricao,
                'assets_type_id' => $asset->uuid_assets_type,
                'created_at' => $asset->created_at,
                'updated_at' => $asset->updated_at,
                'deleted_at' => $asset->deleted_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets_tmp');
    }
};
