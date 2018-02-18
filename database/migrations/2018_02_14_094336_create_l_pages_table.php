<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('l_domain_id');
            $table->string('name');
            $table->text('content')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamps();

            $table->foreign('l_domain_id')
                ->references('id')->on('l_domains');

            $table->unique(['l_domain_id','name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_pages');
    }
}
