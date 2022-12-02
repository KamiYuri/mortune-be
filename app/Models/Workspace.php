<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    /**
     * @var array
     */
    protected $fillable = ['owner_id', 'name', 'description'];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    /**
     * @return HasMany
     */
    public function boards(): HasMany
    {
        return $this->hasMany('App\Models\Board');
    }
}
