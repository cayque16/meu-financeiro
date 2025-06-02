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
        Schema::table('brokerages', function (Blueprint $table) {
            $table->renameColumn('nome', 'name');
        });
        Schema::table('brokerages', function (Blueprint $table) {
            $table->renameColumn('site', 'web_page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brokerages', function (Blueprint $table) {
            $table->renameColumn('name', 'nome');
        });
        Schema::table('brokerages', function (Blueprint $table) {
            $table->renameColumn('web_page', 'site');
        });
    }
};
