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
        DB::statement('ALTER TABLE brokerages MODIFY id BIGINT UNSIGNED');

        DB::statement('ALTER TABLE brokerages DROP PRIMARY KEY');

        DB::statement('ALTER TABLE brokerages ADD PRIMARY KEY (uuid)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE brokerages DROP PRIMARY KEY');

        DB::statement('ALTER TABLE brokerages MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
    }
};
