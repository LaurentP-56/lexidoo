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
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('created_on', 20);
            $table->string('amount', 10);
            $table->string('starts_on', 20);
            $table->string('ends_on', 20);
            $table->string('status', 20);
            $table->integer('user');
            $table->string('provider', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
