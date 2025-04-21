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
        Schema::table('users', function (Blueprint $table) {
            // Renommer 'name' en 'nom' et 'prenom'
            $table->dropColumn('name');
            $table->string('nom')->nullable()->after('id');
            $table->string('prenom')->nullable()->after('nom');
            
            // Ajouter les champs supplémentaires
            $table->string('tel')->nullable()->after('email');
            $table->string('adresse')->nullable()->after('tel');
            $table->string('ville')->nullable()->after('adresse');
            $table->string('pays')->nullable()->after('ville');
            $table->boolean('premium')->default(0)->after('pays');
            $table->string('offre_premium')->default('')->after('premium');
            $table->string('creationDuCompte')->nullable()->after('offre_premium');
            $table->datetime('finDuPremium')->nullable()->after('creationDuCompte');
            $table->string('image')->nullable()->after('finDuPremium');
            $table->string('provider')->nullable()->after('image');
            $table->string('provider_id')->nullable()->after('provider');
            $table->boolean('isAdmin')->default(0)->after('remember_token');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn([
                'nom', 'prenom', 'tel', 'adresse', 'ville', 'pays',
                'premium', 'offre_premium', 'creationDuCompte', 'finDuPremium',
                'image', 'provider', 'provider_id', 'isAdmin', 'deleted_at'
            ]);
        });
    }
};
