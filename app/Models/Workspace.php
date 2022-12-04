<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $description
 * @property User $user
 * @property Board[] $boards
 */
class Workspace extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['owner_id', 'name', 'description'];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return HasMany
     */
    public function boards(): HasMany
    {
        return $this->hasMany(Board::class);
    }

    /**
     * @return BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'member_workspace', 'workspace_id', 'member_id')->withPivot('role')->withTimestamps();
    }
}
