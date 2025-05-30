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
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('e_excluido');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->renameColumn('uuid', 'id');
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
            $table->renameColumn('id', 'uuid');
            $table->boolean('e_excluido')->default(0);
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });
    }
};
