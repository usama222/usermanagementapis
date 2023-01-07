<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="User Resource",
 *     description="User resource",
 *     @OA\Xml(
 *         name="UserResource"
 *     )
 * )
 */

class UserResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\User[]
     */
    public function toArray($request)
    {
        return [
            'User ID' => $this->user_id,
            'Fullname' => $this->name,
            'Username' => $this->username,
            'email' => $this->email
        ];
    }
}
