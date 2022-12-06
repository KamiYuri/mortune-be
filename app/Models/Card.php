<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['list_id', 'archived', 'description', 'due', 'due_complete', 'title'];

    /**
     * @return BelongsTo
     */
    public function cardList(): BelongsTo
    {
        return $this->belongsTo(CardList::class, 'list_id');
    }

    /**
     * @return BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'card_member', 'card_id', 'member_id')->withPivot('role')->using(CardMember::class);
    }
}
