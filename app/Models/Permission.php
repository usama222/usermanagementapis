<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Permission",
 *     description="Permission model",
 *     @OA\Xml(
 *         name="Permission"
 *     )
 * )
 */

class Permission extends Model
{
    use HasFactory;
    protected $primaryKey = 'permission_id';

    /**
     * @OA\Property(
     *     title="Permission ID",
     *     description="Permission ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $permission_id;

    /**
     * @OA\Property(
     *      title="Permission Name",
     *      description="Name of the new Permission",
     *      example="Update Employee"
     * )
     *
     * @var string
     */

    public $name;

    /**
     * @OA\Property(
     *      title="Permission Slug",
     *      description="Slug of the new Permission",
     *      example="update-employee"
     * )
     *
     * @var string
     */
    public $slug;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function roles()
    {
        return $this->belongsTomany(Role::class, 'roles_permissions', 'permission_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsTomany(User::class, 'users_permissions', 'permission_id', 'user_id');
    }
}
