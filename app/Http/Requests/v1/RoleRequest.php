<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="Role Form Request",
 *      description="role form request body data Validate",
 *      @OA\Xml(
 *         name="RoleRequest"
 *      ),
 *      type="object",
 *      required={"name","slug"}
 * )
 */

class RoleRequest extends FormRequest
{
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

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        if ($method == 'POST') {
            return [
                'name' => 'bail|required|max:255',
                'slug' => 'bail|required|max:255',
            ];
        } else if ($method == 'PUT') {
            return [
                'name' => 'bail|sometimes|required|max:255',
            ];
        }
    }
}
