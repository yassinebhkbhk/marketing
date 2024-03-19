<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('NomPage');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('socialMediaId');
            $table->string('categorie');
            $table->string('Location');
            $table->string('page_access_token');
            $table->string('link')->nullable();
            $table->timestamps();
             // Ajout de la clé étrangère
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('socialMediaId')->references('id')->on('Media_social')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::dropIfExists('pages');
    }
};
