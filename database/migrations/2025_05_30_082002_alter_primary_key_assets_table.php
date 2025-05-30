<?php

use Illuminate\Database\Migrations\Migration;
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
        DB::statement('ALTER TABLE assets MODIFY id BIGINT UNSIGNED');

        DB::statement('ALTER TABLE assets DROP PRIMARY KEY');

        DB::statement('ALTER TABLE assets ADD PRIMARY KEY (uuid)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE assets DROP PRIMARY KEY');

        DB::statement('ALTER TABLE assets MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
    }
};
