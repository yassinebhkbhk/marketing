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
        Schema::create('analyse_postes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('name');
            $table->string('period');
            $table->unsignedBigInteger('value');
            $table->text('description');
            $table->json('data')->nullable();
            $table->dateTime('date')->default(now());
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade'); // Ajout de la contrainte de clé étrangère pour la page

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyse_postes');
    }
};
