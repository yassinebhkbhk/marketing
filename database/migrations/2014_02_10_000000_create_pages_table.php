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
        Schema::create('page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('name_page');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('social_media_id');
            $table->string('categorie');
            $table->string('location');
            $table->string('page_access_token');
            $table->string('link')->nullable();
            $table->text('picture_url')->nullable();
            $table->text('cover_picture_url')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
            $table->integer('rating_count')->default(0);
            $table->integer('fan_count')->default(0);
            $table->string('email')->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('social_media_id')->references('id')->on('Media_social')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::dropIfExists('page');
    }
};
