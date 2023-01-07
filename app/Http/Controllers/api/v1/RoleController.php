<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PaginationRequest;
use App\Http\Requests\v1\RoleRequest;
use App\Http\Resources\v1\RoleResource;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{


    /**
     * @OA\Get(
     *      path="/roles",
     *      operationId="get roles",
     *      tags={"Roles"},
     *      summary="Get list of Roles",
     *      description="Returns list of Roles",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RoleResource")
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
    public function index()
    {

        // abort_if(Gate::denies('roles-access'), 403);
        // $pagesize = $request->pagesize ?? 20;
        return RoleResource::collection(Role::simplePaginate(10));
    }
    // public function index(PaginationRequest $request)
    // {

    //     abort_if(Gate::denies('roles-access'), 403);
    //     $pagesize = $request->pagesize ?? 20;
    //     return RoleResource::collection(Role::simplePaginate($pagesize));
    // }

    /**
     * @OA\Post(
     *      path="/roles",
     *      operationId="store role",
     *      tags={"Roles"},
     *      summary="Store Single new Role",
     *      description="Returns Inserted Role Resource",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RoleRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RoleResource")
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
    public function store(RoleRequest $request)
    {

        abort_if(Gate::denies('role-create'), 403);
        $role = Role::create($request->validated());
        return response()->singleresource(new RoleResource($role), '1.0');
    }

    /**
     * @OA\Get(
     *      path="/roles/{id}",
     *      operationId="getRoleById",
     *      tags={"Roles"},
     *      summary="Get Role information",
     *      description="Returns Role Resource",
     *      @OA\Parameter(
     *          name="id",
     *          description="Role id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RoleResource")
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
    public function show(Role $role)
    {
        abort_if(Gate::denies('single-role-access'), 403);
        return response()->singleresource(new RoleResource($role), '1.0');
    }
    /**
     * @OA\Put(
     *      path="/roles/{id}",
     *      operationId="updateRole",
     *      tags={"Roles"},
     *      summary="Update existing Role",
     *      description="Returns updated Role Resource",
     *      @OA\Parameter(
     *          name="id",
     *          description="Role id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RoleRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RoleResource")
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
    public function update(RoleRequest $request, Role $role)
    {
        abort_if(Gate::denies('role-update'), 403);
        $role->update($request->validated());
        return response()->singleresource(new RoleResource($role), '1.0');
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
     *      path="/roles/permission",
     *      operationId="storeRolePermisson",
     *      tags={"RolePermissions"},
     *      summary="Store new Role Permission",
     *      description="Returns Role permission Resource",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\Schema(
     *              @OA\Property(
     *                  type="object",
     *                  @OA\Property(
     *                       property="role_id",
     *                       type="integer"
     *                  ),
     *                   @OA\Property(
     *                       property="permission_id",
     *                       type="integer"
     *                  )
     *              ),
     *              example={
     *                  "role_id":"1- (Hr Manager)",
     *                  "permission_id":"2- (Update Employee Information)"
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="Role ID", type="number", example=1),
     *              @OA\Property(property="Role Name", type="string", example="Hr Manager"),
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

    public function rolespermissionstore(Request $request)
    {
        abort_if(Gate::denies('rolepermissions-create'), 403);
        //short way of updateorcreate minimum qurey excute use 'upsert'
        $request->only(['role_id', 'permission_id']);
        $request->validate([
            'role_id' => 'required|numeric',
            'permission_id' => 'required|array',
        ]);
        $data = array();
        foreach ($request->permission_id as $value) {
            $data[] = [
                'role_id' => $request->role_id,
                'permission_id' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('roles_permissions')->upsert($data, ['role_id', 'permission_id'], ['role_id', 'permission_id']);
    }
}
