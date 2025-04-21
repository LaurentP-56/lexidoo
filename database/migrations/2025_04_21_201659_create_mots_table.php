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
        Schema::create('mots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('theme_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->string('levels')->nullable();
            $table->string('nom');
            $table->string('traduction');
            $table->binary('audioblob')->nullable();
            $table->string('audio')->nullable();
            $table->string('gratuit');
            $table->string('probability_of_appearance')->default('20');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('theme_id')
                  ->references('id')
                  ->on('themes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('sub_category_id')
                  ->references('id')
                  ->on('sub_categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('level_id')
                  ->references('id')
                  ->on('levels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mots');
    }
};
