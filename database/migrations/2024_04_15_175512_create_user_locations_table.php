<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('country');
            $table->char('country_code', 2);
            $table->char('region', 2);
            $table->string('region_name');
            $table->string('city');
            $table->string('zip');
            $table->string('timezone');
            $table->string('ip');
            $table->string('user_agent');
            $table->boolean('first_entry');
            $table->timestamps();
            // fk with users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('user_locations');
        Schema::enableForeignKeyConstraints();
    }
}
