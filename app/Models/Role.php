<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $role
 */
class Role extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['role'];
}
