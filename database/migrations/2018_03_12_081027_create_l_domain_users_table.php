<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLDomainUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_domain_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('l_domain_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->unique('l_domain_id','user_id');
            $table->foreign('l_domain_id')
                ->references('id')
                ->on('l_domains');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_domain_users');
    }
}
