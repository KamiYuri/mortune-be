<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property integer $member_id
 * @property integer $workspace_id
 * @property string $created_at
 * @property string $updated_at
 * @property BoardMember[] $boardMembers
 * @property User $user
 * @property Role $role
 * @property Workspace $laravel-app
 */
class WorkspaceMember extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_workspace';

    /**
     * @var array
     */
    protected $fillable = ['role', 'created_at', 'updated_at'];

    /**
     * @return HasMany
     */
    public function boardMembers(): HasMany
    {
        return $this->hasMany(BoardMember::class, 'member_id', 'member_id');
    }

    /**
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role');
    }

    /**
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }
}
