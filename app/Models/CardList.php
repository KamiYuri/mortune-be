<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $board_id
 * @property string $title
 * @property boolean $archived
 * @property Board $board
 * @property Card[] $cards
 */
class CardList extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['board_id', 'title', 'archived'];

    /**
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo('App\Models\Board');
    }

    /**
     * @return HasMany
     */
    public function cards(): HasMany
    {
        return $this->hasMany('App\Models\Card', 'list_id');
    }
}
