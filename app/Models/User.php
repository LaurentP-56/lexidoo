<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'tel',
        'adresse',
        'ville',
        'pays',
        'premium',
        'offre_premium',
        'creationDuCompte',
        'finDuPremium',
        'image',
        'provider',
        'provider_id',
        'isAdmin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'premium' => 'boolean',
            'isAdmin' => 'boolean',
            'finDuPremium' => 'datetime',
        ];
    }

    /**
     * Obtenir les mots appris par l'utilisateur.
     */
    public function motAppris(): HasOne
    {
        return $this->hasOne(UserMotAppris::class);
    }

    /**
     * Obtenir les probabilités des mots pour l'utilisateur.
     */
    public function wordProbabilities(): HasMany
    {
        return $this->hasMany(UserWordProbability::class);
    }

    /**
     * Obtenir les paiements de l'utilisateur.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user');
    }
}
