<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('l_domain_id');
            $table->string('name');
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('l_domain_id')
                ->references('id')
                ->on('l_domains');

            $table->index('name','l_domain_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_metas');
    }
}
