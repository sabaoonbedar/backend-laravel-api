<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserPreferedAuthors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_authors', function (Blueprint $table) {
            $table->id()->index();
            $table->bigInteger('users_id')->unsigned();
            $table->string('author_name')->nullable();
            $table->string('author_value')->nullable();
            $table->string('flag')->nullable();
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');


        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dropIfExists('user_has_authors');
    }
}
