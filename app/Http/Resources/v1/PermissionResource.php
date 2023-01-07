<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="Permission Resource",
 *     description="Permission resource",
 *     @OA\Xml(
 *         name="PermissionResource"
 *     )
 * )
 */

class PermissionResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Permission[]
     */
    public function toArray($request)
    {
        return [
            'Permission ID' => $this->permission_id,
            'Permission' => $this->name
        ];
    }
}
