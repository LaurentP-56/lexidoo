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
        Schema::create('user_word_probabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('mot_id');
            $table->integer('probability_of_appearance')->default(50);
            $table->integer('know_level')->nullable();
            $table->integer('dont_know_level')->nullable();
            $table->boolean('dont_want_to_learn')->default(0);
            $table->timestamps();
            
            $table->unique(['user_id', 'mot_id'], 'user_mot_unique');
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
                  
            $table->foreign('mot_id')
                  ->references('id')
                  ->on('mots')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_word_probabilities');
    }
};
