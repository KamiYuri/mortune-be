<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Workspace;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes as OA;

class WorkspaceController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table("workspaces")->get();
        
        return response()->json($data);
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
        $ws = new WorkSpace;
        $ws->name = $req->name;
        $ws->description = $req->description;
        $ws->created_at = now();
        $ws->updated_at = now();
        $ws->save();//luu dl vaof database

        //gui ve dl sau khi them
        $data = DB::table("workspaces")->get();
        return response()->json($data);
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
        
        $data = DB::table('workspaces')->find($id);
        return response()->json($data);
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
        $name = $req->name;
        $description = $req->description;
        $created_at = now();
        $updated_at = now();
        
        DB::table('workspaces')
            ->where('id', $id)
            ->update(['name' => $name, 'description'=> $description, 'created_at'=> $created_at, 'updated_at'=> $updated_at]);

        //gui ve dl sau khi them
        $data = DB::table("workspaces")->get();
        return response()->json($data);
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
        
        $deleted = DB::table('workspaces')->where('id', '=', $id)->delete();
        //gui ve dl sau khi them
        $data = DB::table("workspaces")->get();
        return response()->json($data);
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
        
        //$data = DB::table('workspaces')->find($id);
        $data = DB::table('users')->join('member_workspace', 'users.id', '=', 'member_workspace.member_id')
        ->where('member_workspace.workspace_id', '=', $id)
        ->select('users.id', 'member_workspace.role', 'users.username', 'users.updated_at', 'users.created_at')->get();
        return response()->json($data);
    }
}
