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
        Schema::create('assets_type_tmp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('name', 30);
            $table->char('description', 150);
            $table->timestamps();
            $table->softDeletes();
        });

        $types = DB::table('assets_types')->get();

        foreach ($types as $type) {
            DB::table('assets_type_tmp')->insert([
                'id' => $type->uuid,
                'name' => $type->nome,
                'description' => $type->descricao,
                'created_at' => $type->created_at,
                'updated_at' => $type->updated_at,
                'deleted_at' => $type->deleted_at,
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
        Schema::dropIfExists('assets_type_tmp');
    }
};
