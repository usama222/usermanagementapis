<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Permission Form Request",
 *      description="permission form request body data Validate",
 *      @OA\Xml(
 *         name="PermissionRequest"
 *      ),
 *      type="object",
 *      required={"name","slug"}
 * )
 */
class PermissionRequest extends FormRequest
{
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
                'name' => 'bail|sometimes|required|max:255'
            ];
        }
    }
}
