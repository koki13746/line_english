<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->bigInteger('word_id')->nullable();
            //$table->bigInteger('user_id')->nullable();
            $table->boolean('mode_sort');
            $table->boolean('mode_english');
            $table->char('name_japanese', 50);
            $table->char('name_english', 50);
            $table->boolean('ok');
            $table->boolean('not_ok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
