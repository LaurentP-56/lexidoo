<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use SoftDeletes;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'theme_id',
        'category_id',
        'name'
    ];

    /**
     * Obtenir le thème auquel cette sous-catégorie appartient.
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Obtenir la catégorie à laquelle cette sous-catégorie appartient.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtenir les mots associés à cette sous-catégorie.
     */
    public function mots(): HasMany
    {
        return $this->hasMany(Mot::class);
    }

    /**
     * Obtenir les icônes de validation associées à cette sous-catégorie.
     */
    public function validationIcons(): HasMany
    {
        return $this->hasMany(ValidationIcon::class);
    }
}
