<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('analyse_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->json('data');
            $table->date('date');
            $table->timestamps();

            // Ajout de la clé étrangère
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analyse_pages');
    }
};
