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
        Schema::create('control_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_referencia');
            $table->bigInteger('id_table_references')->constrained('table_references');
            $table->text('nome_original');
            $table->char('extensao', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_files');
    }
};
