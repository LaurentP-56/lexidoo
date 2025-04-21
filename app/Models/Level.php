<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use SoftDeletes;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'label',
        'sub_label',
        'classe'
    ];

    /**
     * Obtenir les mots associés à ce niveau.
     */
    public function mots(): HasMany
    {
        return $this->hasMany(Mot::class);
    }
}
