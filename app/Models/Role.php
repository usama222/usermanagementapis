<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Role",
 *     description="Role model",
 *     @OA\Xml(
 *         name="Role"
 *     )
 * )
 */

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';

    /**
     * @OA\Property(
     *     title="Role ID",
     *     description="Role ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $role_id;
    /**
     * @OA\Property(
     *      title="Role Name",
     *      description="Name of the new Role",
     *      example="Hr Manager"
     * )
     *
     * @var string
     */

    public $name;
    /**
     * @OA\Property(
     *      title="Role Slug",
     *      description="Slug of the new Role",
     *      example="hr-manager"
     * )
     *
     * @var string
     */
    public $slug;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'role_id', 'permission_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles', 'role_id', 'user_id');
    }
}
