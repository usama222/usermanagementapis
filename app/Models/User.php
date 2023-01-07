<?php

namespace App\Models;

use App\Traits\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;

    protected $primaryKey = 'user_id';

    /**
     * @OA\Property(
     *     title="User ID",
     *     description="User ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $user_id;
    /**
     * @OA\Property(
     *      title="User Fullname",
     *      description="Fullname of the new User",
     *      example="Usamauddin"
     * )
     *
     * @var string
     */

    public $name;
    /**
     * @OA\Property(
     *      title="Username",
     *      description="Username of the new User",
     *      example="usama44"
     * )
     *
     * @var string
     */

    public $username;
    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email of the new User",
     *      example="usama@gmail.com"
     * )
     *
     * @var string
     */

    public $email;
    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the new User",
     *      example="password@4422"
     * )
     *
     * @var string
     */
    public $password;


    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value, [
            'round' => 12
        ]);
    }
}
