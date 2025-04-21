<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use SoftDeletes;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Obtenir les catégories associées à ce thème.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Obtenir les sous-catégories associées à ce thème.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Obtenir les mots associés à ce thème.
     */
    public function mots(): HasMany
    {
        return $this->hasMany(Mot::class);
    }

    /**
     * Obtenir les icônes de validation associées à ce thème.
     */
    public function validationIcons(): HasMany
    {
        return $this->hasMany(ValidationIcon::class);
    }
}
