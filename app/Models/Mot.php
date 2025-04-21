<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mot extends Model
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
        'sub_category_id',
        'level_id',
        'levels',
        'nom',
        'traduction',
        'audioblob',
        'audio',
        'gratuit',
        'probability_of_appearance'
    ];

    /**
     * Obtenir le thème auquel ce mot appartient.
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Obtenir la catégorie à laquelle ce mot appartient.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtenir la sous-catégorie à laquelle ce mot appartient.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Obtenir le niveau auquel ce mot appartient.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Obtenir les probabilités d'utilisateur associées à ce mot.
     */
    public function userProbabilities(): HasMany
    {
        return $this->hasMany(UserWordProbability::class);
    }
}
