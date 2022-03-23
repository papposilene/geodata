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
        Schema::create('geodata__continents', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique();
            $table->string('name', 255)->unique();
            $table->timestamps();
        });

        Schema::create('geodata__subcontinents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->string('continent_slug', 255);
            $table->timestamps();

            $table->foreign('continent_slug')->references('slug')->on('geodata__continents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geodata__subcontinents');
        Schema::drop('geodata__continents');
    }
};
