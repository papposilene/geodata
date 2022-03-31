<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Papposilene\Geodata\GeodataRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geodata__countries', function (Blueprint $table) {
            $table->uuid();
            $table->string('continent_slug', 255);
            $table->string('subcontinent_slug', 255);
            // Various identifiant codes
            $table->string('cca2', 2)->unique();
            $table->string('cca3', 3)->unique();
            $table->string('ccn3', 3)->nullable();
            // Name, common and formal, in english
            $table->string('name_eng_common', 255)->unique();
            $table->string('name_eng_formal', 255)->unique();
            // Centered geolocation (for mainland if necessary)
            $table->decimal('lat', 20, 16)->nullable();
            $table->decimal('lon', 20, 16)->nullable();
            // Borders
            $table->boolean('landlocked')->default(false);
            $table->json('neighbourhood')->nullable();
            // Geopolitic status
            $table->string('status', 255)->nullable();
            $table->boolean('independent')->default(true);
            // Flag
            $table->string('flag', 50)->nullable();
            // Extra data in JSON
            $table->json('capital')->nullable();
            $table->json('currencies')->nullable();
            $table->json('demonyms')->nullable();
            $table->json('dialling')->nullable();
            $table->json('languages')->nullable();
            $table->json('name_native')->nullable();
            $table->json('name_translations')->nullable();
            $table->json('extra')->nullable();
            // Internal data
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('continent_slug')->references('slug')->on('geodata__continents');
            $table->foreign('subcontinent_slug')->references('slug')->on('geodata__subcontinents');
        });

        Schema::create('geodata__regions', function (Blueprint $table) {
            $table->uuid()->primary();
            // Country identifiers
            $table->string('country_cca2', 2);
            $table->string('country_cca3', 3);
            // Region identifiers
            $table->string('region_cca2', 6)->nullable();
            // OpenStreetMap ID
            $table->bigInteger('osm_place_id', false)->nullable();
            $table->integer('admin_level', false);
            // Name, common and formal, in english
            $table->string('type', 255)->nullable();
            $table->string('name_loc', 255);
            $table->string('name_eng', 255);
            $table->json('name_translations');
            $table->json('extra')->nullable();
            // Internal data
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_cca2')->references('cca2')->on('geodata__countries');
            $table->foreign('country_cca3')->references('cca3')->on('geodata__countries');
        });

        Schema::create('geodata__cities', function (Blueprint $table) {
            $table->uuid()->primary();
            // Administrative layers
            $table->string('country_cca3', 3);
            $table->uuid('region_uuid')->nullable();
            // OpenStreetMap ID
            $table->bigInteger('osm_place_id', false)->nullable();
            $table->integer('admin_level', false);
            $table->string('type', 255)->nullable();
            $table->string('name_loc', 255);
            $table->string('name_eng', 255);
            // Extra data in JSON
            $table->json('name_translations');
            $table->string('postcodes', 20)->nullable();
            $table->json('extra')->nullable();
            // Internal data
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_cca3')->references('cca3')->on('geodata__countries');
            $table->foreign('region_uuid')->references('uuid')->on('geodata__regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geodata__cities');
        Schema::drop('geodata__regions');
        Schema::drop('geodata__countries');
    }
};
