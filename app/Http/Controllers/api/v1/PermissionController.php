<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PaginationRequest;
use App\Http\Requests\v1\PermissionRequest;
use App\Http\Resources\v1\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * @OA\Get(
     *      path="/permissions",
     *      operationId="get permissions",
     *      tags={"Permissions"},
     *      summary="Get list of Permissions",
     *      description="Returns list of Permissions",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PermissionResource")
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
        abort_if(Gate::denies('permissions-access'), 403);
        $pagesize = $request->pagesize ?? 20;
        return PermissionResource::collection(Permission::simplePaginate($pagesize));
    }

    /**
     * @OA\Post(
     *      path="/permissions",
     *      operationId="store permission",
     *      tags={"Permissions"},
     *      summary="Store Single new Permission",
     *      description="Returns Inserted Permission Resource",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PermissionRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PermissionResource")
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
    public function store(PermissionRequest $request)
    {
        abort_if(Gate::denies('permission-create'), 403);
        $permission = Permission::create($request->validated());
        return response()->singleresource(new PermissionResource($permission), '1.0');
    }

    /**
     * @OA\Get(
     *      path="/permissions/{id}",
     *      operationId="getPermissionById",
     *      tags={"Permissions"},
     *      summary="Get Permission information",
     *      description="Returns Permission Resource",
     *      @OA\Parameter(
     *          name="id",
     *          description="Permission id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PermissionResource")
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
    public function show(Permission $permission)
    {
        abort_if(Gate::denies('single-permission-access'), 403);
        return response()->singleresource(new PermissionResource($permission), '1.0');
    }

    /**
     * @OA\Put(
     *      path="/permissions/{id}",
     *      operationId="UpdatePermission",
     *      tags={"Permissions"},
     *      summary="Update existing Permission",
     *      description="Returns updated Permissions Resource",
     *      @OA\Parameter(
     *          name="id",
     *          description="Permission id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PermissionRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PermissionResource")
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
    public function update(PermissionRequest $request, $permission)
    {
        abort_if(Gate::denies('permission-update'), 403);
        $permission->update($request->validated());
        return response()->singleresource(new PermissionResource($permission), '1.0');
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
}
