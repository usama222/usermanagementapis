<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="User Form Request",
 *      description="user form request body data Validate",
 *      @OA\Xml(
 *         name="UserRequest"
 *      ),
 *      type="object",
 *      required={"name","username","email","password"}
 * )
 */

class UserRequest extends FormRequest
{
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
                'username' => 'bail|required|string',
                'email' => 'bail|required|email',
                'password' => 'bail|required|string',
            ];
        } else if ($method == 'PUT') {
            return [
                'name' => 'bail|sometimes|required|max:255',
            ];
        }
    }
}
