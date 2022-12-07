<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property integer $card_id
 * @property integer $member_id
 * @property string $created_at
 * @property string $updated_at
 * @property Card $card
 * @property BoardMember $boardMember
 * @property Role $role
 */
class CardMember extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'card_member';

    /**
     * @var array
     */
    protected $fillable = ['role', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * @return BelongsTo
     */
    public function members(): BelongsTo
    {
        return $this->belongsTo(BoardMember::class, 'member_id', 'member_id');
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role');
    }
}
