<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\LMeta::truncate();
        Schema::table('l_metas', function ($table) {
            $table->unsignedInteger('l_meta_type_id')->default();
            $table->foreign('l_meta_type_id')
                ->references('id')
                ->on('l_meta_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
