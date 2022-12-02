<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $list_id
 * @property boolean $archived
 * @property string $description
 * @property string $due
 * @property boolean $due_complete
 * @property string $title
 * @property CardList $cardList
 */
class Card extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['list_id', 'archived', 'description', 'due', 'due_complete', 'title'];

    /**
     * @return BelongsTo
     */
    public function cardList(): BelongsTo
    {
        return $this->belongsTo('App\Models\CardList', 'list_id');
    }
}
