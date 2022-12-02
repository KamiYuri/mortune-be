<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'email'];

    /**
     * @return HasMany
     */
    public function workspaces(): HasMany
    {
        return $this->hasMany('App\Models\Workspace', 'owner_id');
    }
}
