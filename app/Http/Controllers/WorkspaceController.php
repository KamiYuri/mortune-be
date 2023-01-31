<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Workspace;
use App\Models\WorkspaceMember;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes as OA;
use App\Traits\HttpResponses;

class WorkspaceController extends Controller
{
    use HttpResponses;

    #[OA\Get(
        path: "/workspace", operationId: "workspace", summary: "Get data workspace",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [

                        ],
                        example: []
                    ),
                )
            ]
        ),
        tags: ["Workspace"],
        responses: [
            new Response(response: 200, description: "Get data workspace successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "workspace", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "description", type: "string"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "workspace" => [
                            "id" => 1,
                            "name" => "abc",
                            "description" => "hjhjshjdyuy uysuyu uyu",
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in get data workspace"),
        ],
    )]

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $workspace = Workspace::all();
            return $this->success($workspace);
        } catch (\Exception $error) {
            return $this->error($error, 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    #[Post(
        path: "/workspace", operationId: "workspaceAdd", summary: "Add a workspace",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "name", type: "string"),
                            new Property(property: "description", type: "string"),
                        ],
                        example: ["name" => "abc le.org", "description" => "pass word"]
                    ),
                )
            ]
        ),
        tags: ["Workspace"],
        responses: [
            new Response(response: 200, description: "Add data workspace successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "workspace", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "description", type: "string"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "workspace" => [
                            "id" => 1,
                            "name" => "abc",
                            "description" => "hjhjshjdyuy uysuyu uyu",
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in add workspace"),
        ],
    )]
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            if(is_null($req->name) || is_null($req->description)){
                return $this->error("Missing fields!", 401);
            }

            $ws = new WorkSpace;
            $ws->name = $req->name;
            $ws->description = $req->description;
            $ws->created_at = now();
            $ws->updated_at = now();

            $ws->save();//luu dl vaof database
            $user_id = auth()->id();
            $ws_member = new WorkspaceMember;
            $ws_member->member_id = $user_id;
            $ws_member->workspace_id = $ws->id;
            $ws_member->role = 1;
            $ws_member->created_at = now();
            $ws_member->updated_at = now();
            $ws_member->save();
            //gui ve dl sau khi them


            return $this->success($ws, 'OK');
        } catch (\Exception $error) {
            return $this->error($error, 404);
        }
        
    }

    #[OA\Get(
        path: "/workspace/{id}", operationId: "workspaceGetById", summary: "Get data workspace by id",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int")
                        ],
                        example: ["id"=>1]
                    ),
                )
            ]
        ),
        tags: ["Workspace"],
        responses: [
            new Response(response: 200, description: "Get a workspace by id successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "workspace", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "description", type: "string"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "workspace" => [
                            "id" => 1,
                            "name" => "abc",
                            "description" => "hjhjshjdyuy uysuyu uyu",
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in get workspace by id"),
        ],
    )]
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $data = DB::table('workspaces')->find($id);
            return $this->success($data);
        } catch (\Exception $error) {
            return $this->error($error, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    #[OA\Put(
        path: "/workspace{id}", operationId: "workspaceUpdate", summary: "Update workspace",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "description", type: "string")
                        ],
                        example: [
                            "id" => 1,
                            "name" => "abc",
                            "description" => "hjhjshjdyuy uysuyu uyu"

                        ]
                    ),
                )
            ]
        ),
        tags: ["Workspace"],
        responses: [
            new Response(response: 200, description: "Update workspace successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "workspace", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "description", type: "string"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "workspace" => [
                            "id" => 1,
                            "name" => "abc",
                            "description" => "hjhjshjdyuy uysuyu uyu",
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in update workspace"),
        ],
    )]
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, int $id)
    {
        try {
            $name = $req->name;
            $description = $req->description;
            $created_at = now();
            $updated_at = now();

            DB::table('workspaces')
                ->where('id', $id)
                ->update(['name' => $name, 'description'=> $description, 'created_at'=> $created_at, 'updated_at'=> $updated_at]);

            //gui ve dl sau khi them
            $data = DB::table("workspaces")->get();
            return $this->success($data);
        } catch (\Exception $error) {
            return $this->error($error, 404);
        }
    }

    #[OA\Delete(
        path: "/workspace{id}", operationId: "workspaceDelete", summary: "Delete a workspace",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int"),
                        ],
                        example: ["id"=>1]
                    ),
                )
            ]
        ),
        tags: ["Workspace"],
        responses: [
            new Response(response: 200, description: "Delete workspace successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "workspace", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "description", type: "string"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "workspace" => [
                            "id" => 1,
                            "name" => "abc",
                            "description" => "hjhjshjdyuy uysuyu uyu",
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in delete workspace"),
        ],
    )]
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $deleted = DB::table('workspaces')->where('id', '=', $id)->delete();
            $workspace_member = DB::table('member_workspace')->where('workspace_id', $id)->delete();
            //gui ve dl sau khi them
            $data = DB::table("workspaces")->get();
            return $this->success($data);
        } catch (\Exception $error) {
            return $this->error($error, 404);
        }
    }

    //get list user by workspace id
    #[OA\Get(
        path: "/workspace/user{id}", operationId: "getListUserByIdWs", summary: "Get data user by id",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int")
                        ],
                        example: ["id"=>1]
                    ),
                )
            ]
        ),
        tags: ["Workspace"],
        responses: [
            new Response(response: 200, description: "Get list user by id successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "workspace", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "role", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "workspace" => [
                            "id" => 1,
                            "role" => 1,
                            "name" => "hjhjshjdyuy uysuyu uyu",
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in get user by id ws"),
        ],
    )]
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getListUserByIdWs($id)
    {

        try {
            //$data = DB::table('workspaces')->find($id);
            $data = DB::table('users')->join('member_workspace', 'users.id', '=', 'member_workspace.member_id')
            ->where('member_workspace.workspace_id', '=', $id)
            ->select('users.id', 'member_workspace.role', 'users.username', 'users.updated_at', 'users.created_at')->get();    
            return $this->success($data);
        } catch (\Exception $error) {
            return $this->error($error, 404);
        }
    }

    public function getWorkspaceByUserID(int $id){
        try{
            $workspace = DB::table('workspaces')->join('member_workspace', 'workspaces.id', '=', 'member_workspace.workspace_id')
            ->where('member_workspace.member_id', '=', $id)
            ->select('workspaces.id', 'workspaces.name', 'workspaces.description', 'workspaces.created_at', 'workspaces.updated_at')
            ->get();

            return $this->success($workspace, 'OK');
        }catch(Exception $error){
            return $this->success($error, 500);
        }
    }

    public function addMemberToWorkspace(Request $request){
        try{
            if(is_null($request->workspace_id) || is_null($request->member_id)){
                return $this->error("Missing fields!", 401);
            }
            $user_id = $request->member_id;
            $workspace_id = $request->workspace_id;
            $ws_mb = DB::table('member_workspace')->where('member_id', $user_id)->where('workspace_id', $workspace_id)
            ->first();

            if(!is_null($ws_mb)){
                return $this->error('Member already in this workspace!', 402);
            }

            $ws_member = new WorkspaceMember;
            $ws_member->member_id = $user_id;
            $ws_member->workspace_id = $workspace_id;
            $ws_member->role = 2;
            $ws_member->created_at = now();
            $ws_member->updated_at = now();
            $ws_member->save();

            return $this->success($ws_member, 'OK');
        }catch(Exception $error){
            return $this->error($error, 500);
        }
        


    }
}
