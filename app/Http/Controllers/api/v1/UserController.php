<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PaginationRequest;
use App\Http\Requests\v1\UserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="get users",
     *      tags={"Users"},
     *      summary="Get list of Users",
     *      description="Returns list of Users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(PaginationRequest $request)
    {
        abort_if(Gate::denies('users-access'), 403);
        $pagesize = $request->pagesize ?? 20;
        return UserResource::collection(User::simplePaginate($pagesize));
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="store user",
     *      tags={"Users"},
     *      summary="Store Single new User",
     *      description="Returns Inserted User Resource",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(UserRequest $request)
    {
        abort_if(Gate::denies('user-create'), 403);
        $user = User::create($request->validated());
        return response()->singleresource(new UserResource($user), '1.0');
    }
    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="getUserById",
     *      tags={"Users"},
     *      summary="Get User information",
     *      description="Returns User Resource",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function show(User $user)
    {
        abort_if(Gate::denies('single-user-access'), 403);
        return response()->singleresource(new UserResource($user));
    }

    /**
     * @OA\Put(
     *      path="/users/{id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update existing User",
     *      description="Returns updated User Resource",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UserRequest $request, User $user)
    {
        abort_if(Gate::denies('user-update'), 403);
        $user->update($request->validated());
        return response()->singleresource(new UserResource($user), '1.0');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * @OA\Post(
     *      path="/users/permission",
     *      operationId="storeUserPermisson",
     *      tags={"UserPermissions"},
     *      summary="Store new User Permission",
     *      description="Returns User Permission Resource",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\Schema(
     *              @OA\Property(
     *                  type="object",
     *                  @OA\Property(
     *                       property="user_id",
     *                       type="integer"
     *                  ),
     *                   @OA\Property(
     *                       property="permission_id",
     *                       type="integer"
     *                  )
     *              ),
     *              example={
     *                  "user_id":"1- (Usamauddin)",
     *                  "permission_id":"2- (Update Employee Information)"
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="User ID", type="number", example=1),
     *              @OA\Property(property="User Name", type="string", example="Usamauddin"),
     *              @OA\Property(property="Permission ID", type="string", example="2"),
     *              @OA\Property(property="Permission Name", type="string", example="Update Employee Information"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function userpermissionstore(Request $request)
    {
        abort_if(Gate::denies('userpermissions-create'), 403);
        $request->validate([
            'user_id' => 'required|numeric',
            'permission_id' => 'required|array',

        ]);
        $data = array();
        foreach ($request->permission_id as $value) {
            $data[] = [
                'user_id' => $request->user_id,
                'permission_id' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('users_permissions')->upsert($data, ['user_id', 'permission_id'], ['user_id', 'permission_id']);
    }
}
