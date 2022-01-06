<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string|null $name
 */
class User extends Model
{
    protected $fillable = [
        'name',
        'username',
        'email',
    ];

    public $timestamps = false;
}
