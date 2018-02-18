<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('l_page_id');
            $table->text('element');
            $table->text('frame');
            $table->timestamps();

            $table->foreign('l_page_id')
                ->references('id')->on('l_pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_blocks');
    }
}
