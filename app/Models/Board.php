<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $workspace_id
 * @property string $title
 * @property boolean $closed
 * @property Workspace $workspace
 * @property CardList[] $cardLists
 */
class Board extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['workspace_id', 'title', 'closed'];

    /**
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * @return HasMany
     */
    public function cardLists(): HasMany
    {
        return $this->hasMany(CardList::class);
    }


    /**
     * @return BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_member', 'board_id', 'member_id')->withPivot('role')->using(BoardMember::class);
    }
}
