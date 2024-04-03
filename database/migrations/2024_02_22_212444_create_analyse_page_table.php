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
        Schema::create('analyse_page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('name');
            $table->string('period');
            $table->unsignedBigInteger('value');
            $table->text('description');
            $table->json('data')->nullable();
            $table->dateTime('date')->default(now());
            $table->timestamps(); // Ajout des timestamps 'created_at' et 'updated_at'

            // Ajout de la clé étrangère
            $table->foreign('page_id')->references('id')->on('page')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analyse_page');
    }
};
