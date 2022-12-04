<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property Workspace[] $workspaces
 */
class User extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'email'];

    /**
     * @return BelongsToMany
     */
    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'member_workspace', 'member_id', 'workspace_id')->withPivot('role')->withTimestamps();
    }
}
