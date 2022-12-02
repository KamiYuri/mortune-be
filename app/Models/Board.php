<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    /**
     * @var array
     */
    protected $fillable = ['workspace_id', 'title', 'closed'];

    /**
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo('App\Models\Workspace');
    }

    /**
     * @return HasMany
     */
    public function cardLists(): HasMany
    {
        return $this->hasMany('App\Models\CardList');
    }
}
