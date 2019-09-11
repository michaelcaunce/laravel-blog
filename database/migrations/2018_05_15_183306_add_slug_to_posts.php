<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('posts', function ($table) {
            $table->string('slug')->unique()->after('body');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Only thing we want to reverse is the column, not the table.
        Schema::table('posts', function($table) {
          $table->dropColumn('slug');
        });
    }
}
