<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property integer $board_id
 * @property integer $member_id
 * @property string $created_at
 * @property string $updated_at
 * @property Board $board
 * @property WorkspaceMember $memberWorkspace
 * @property Role $role
 * @property CardMember[] $cardMembers
 */
class BoardMember extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'board_member';

    /**
     * @var array
     */
    protected $fillable = ['role', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * @return BelongsTo
     */
    public function members(): BelongsTo
    {
        return $this->belongsTo(WorkspaceMember::class, 'member_id', 'member_id');
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role');
    }

    /**
     * @return HasMany
     */
    public function cardMembers(): HasMany
    {
        return $this->hasMany(CardMember::class, 'member_id', 'member_id');
    }
}
