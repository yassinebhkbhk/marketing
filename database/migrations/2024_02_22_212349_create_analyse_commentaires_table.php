<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('analyse_commentaires', function (Blueprint $table) {
            $table->id();
            $table->string('comment_id'); // Use 'comment_id' to match the model
            $table->integer('like_count')->nullable(); // Use specific types for each field
            $table->integer('user_likes')->nullable();
            $table->integer('comment_count')->nullable();
            // Add other relevant columns based on your analysis data
            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('commentaires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('analyse_commentaires');
    }
};
