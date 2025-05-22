<?php

use App\Models\AssetsType;
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
        Schema::table("assets_types", function (Blueprint $table) {
            $table->softDeletes();
        });
        AssetsType::where('e_excluido', '=', 1)->chunk(100, function ($types) {
            foreach ($types as $type) {
                $type->deleted_at = now();
                $type->save();
            }
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
            $table->dropSoftDeletes();
        });
    }
};
