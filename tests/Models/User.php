<?php

namespace Tests\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string|null $name
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $updated_at
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
