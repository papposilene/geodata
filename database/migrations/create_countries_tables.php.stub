<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Papposilene\Geodata\GeodataRegistrar;

class CreateCountriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geodata__countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('continent_id');
            $table->unsignedBigInteger('subcontinent_id');
            // Various identifiant codes
            $table->string('cca2', 2)->unique();
            $table->string('cca3', 3)->unique();
            $table->string('ccn3', 3)->nullable();
            $table->string('cioc', 3)->nullable();
            // Name, common and formal, in english
            $table->string('name_eng_common', 255)->unique();
            $table->string('name_eng_formal', 255)->unique();
            // Centered geolocation (for mainland if necessary)
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            // Borders
            $table->boolean('landlocked')->default(false);
            $table->json('neighbourhood')->nullable();
            // Geopolitic status
            $table->string('status', 255)->nullable();
            $table->boolean('independent')->default(true);
            $table->boolean('un_member')->default(true);
            // Flag
            $table->string('flag', 50)->nullable();
            // Extra data in JSON
            $table->json('capital')->nullable();
            $table->json('currencies')->nullable();
            $table->json('demonyms')->nullable();
            $table->json('dialling_codes')->nullable();
            $table->json('languages')->nullable();
            $table->json('name_native')->nullable();
            $table->json('name_translations')->nullable();
            $table->json('extra')->nullable();
            // Internal data
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('continent_id')->references('id')->on('geodata__continents');
            $table->foreign('subcontinent_id')->references('id')->on('geodata__subcontinents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geodata__countries');
    }
}
