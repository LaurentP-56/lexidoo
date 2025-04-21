<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SoftDeletes;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'theme_id',
        'name'
    ];

    /**
     * Obtenir le thème auquel cette catégorie appartient.
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Obtenir les sous-catégories associées à cette catégorie.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Obtenir les mots associés à cette catégorie.
     */
    public function mots(): HasMany
    {
        return $this->hasMany(Mot::class);
    }

    /**
     * Obtenir les icônes de validation associées à cette catégorie.
     */
    public function validationIcons(): HasMany
    {
        return $this->hasMany(ValidationIcon::class);
    }
}
