<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string('post_id');
            $table->unsignedBigInteger('page_id'); // Adding column for page foreign key
            $table->boolean('is_expired')->default(false);
            $table->string('parent_id')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->string('timeline_visibility');
            $table->string('promotion_status');
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_published')->default(true);
            $table->string('message')->nullable();
            $table->text('picture_url')->nullable();
            $table->string('type');
            $table->string('created_time');
            $table->string('updated_time');
            $table->string('from_name')->nullable();
            $table->unsignedBigInteger('from_id')->nullable();
            // $table->timestamps();


            $table->foreign('page_id')->references('id')->on('page')->onDelete('cascade'); // Ajout de la contrainte de clé étrangère pour la page
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
