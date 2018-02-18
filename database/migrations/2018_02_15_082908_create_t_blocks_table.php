<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('t_section_id');
            $table->string('name')->unique();
            $table->string('sandbox')->nullable();
            $table->string('loader')->nullable();
            $table->integer('height');
            $table->text('content');
            $table->timestamps();

            $table->foreign('t_section_id')
                ->references('id')->on('t_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_blocks');
    }
}
