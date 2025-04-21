<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMotAppris extends Model
{
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'know',
        'dont_know',
        'dont_want_to_learn'
    ];

    /**
     * Obtenir l'utilisateur associé à cet enregistrement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
