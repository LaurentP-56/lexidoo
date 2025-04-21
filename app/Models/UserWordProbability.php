<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWordProbability extends Model
{
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'mot_id',
        'probability_of_appearance',
        'know_level',
        'dont_know_level',
        'dont_want_to_learn'
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'probability_of_appearance' => 'integer',
        'know_level' => 'integer',
        'dont_know_level' => 'integer',
        'dont_want_to_learn' => 'boolean'
    ];

    /**
     * Obtenir l'utilisateur associé à cette probabilité.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le mot associé à cette probabilité.
     */
    public function mot(): BelongsTo
    {
        return $this->belongsTo(Mot::class);
    }
}
