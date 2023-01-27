<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['board_id', 'title', 'archived'];

    /**
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * @return HasMany
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'list_id');
    }
}
