<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Board;

use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes as OA;



class BoardController extends Controller
{

    #[get(
        path: "/board",
        operationId: "board_index",
        summary: "Get data boards",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [],
                        example: []
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get data board succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "board", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object"),
                    ],
                    example: [
                        "user" => [
                            "id" => 1,
                            "title" => "iure",
                            "workspace_id" => 1,
                            "closed" => 1,
                            "updated_at" => "2023-01-08 01:04:24",
                            "created_at" => "2023-01-08 01:04:24"
                        ]
                    ]
                ),
            ),
            new Response(response: 500, description: "Failed to get data board!!!"),
        ],
    )]

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = DB::table("boards")->get();

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'Get data board succesfully!!',
                    'data' => $data
                ]
            );
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to get data board!!!'
                ]
            );
        }
    }


    #[post(
        path: "/board",
        operationId: "board_create",
        summary: "Create a new board",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                        ],
                        example: ["title" => "iure", "workspace_id" => 1, "closed" => 0]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Create board succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "board", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object"),
                    ],
                    example: [
                        "user" => [
                            "id" => 1,
                            "title" => "iure",
                            "workspace_id" => 1,
                            "closed" => 1,
                            "updated_at" => "2023-01-08 01:04:24",
                            "created_at" => "2023-01-08 01:04:24"
                        ]
                    ]
                ),
            ),
            new Response(response: 500, description: "Failed to create board!!!"),
        ],
    )]

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $tmpBoard = new Board();
            $tmpBoard->title = ($request->title != null ? $request->title : "New title");
            $tmpBoard->workspace_id = $request->workspace_id;
            $tmpBoard->closed = ($request->closed != null ? $request->closed : 1);

            $tmpBoard->save();

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'Create board succesfully!!',
                    'data' => $tmpBoard
                ]
            );
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to create board!!!'
                ]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



    #[get(
        path: "/board/{id}",
        operationId: "board_show_by_ID",
        summary: "Get data a board by ID",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int"),
                        ],
                        example: ["id" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Found board succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "board", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object"),
                    ],
                    example: [
                        "user" => [
                            "id" => 1,
                            "title" => "iure",
                            "workspace_id" => 1,
                            "closed" => 1,
                            "updated_at" => "2023-01-08 01:04:24",
                            "created_at" => "2023-01-08 01:04:24"
                        ]
                    ]
                ),
            ),
            new Response(response: 404, description: "Not found board!!!"),
            new Response(response: 500, description: "Failed to found board!!!"),
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
            $board = DB::table('boards')->where('id', $id)->first();
        } catch (Exception $err) {
            return response()->json([
                'code' => '500',
                'message' => 'Failed to found board!!!'
            ]);
        }

        if ($board != null) {
            return response()->json([
                'code' => '200',
                'message' => 'Found board succesfully!!',
                'data' => $board
            ]);
        } else {
            return response()->json([
                'code' => '404',
                'message' => 'Not found board!!!'
            ]);
        }
    }


    #[put(
        path: "/board/{id}",
        operationId: "board_edit_by_ID",
        summary: "Update board by ID",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                        ],
                        example: ["id" => 1, "title" => "iure", "workspace_id" => 1, "closed" => 0]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Found board succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "board", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object"),
                    ],
                    example: [
                        "user" => [
                            "id" => 1,
                            "title" => "iure",
                            "workspace_id" => 1,
                            "closed" => 1,
                            "updated_at" => "2023-01-08 01:04:24",
                            "created_at" => "2023-01-08 01:04:24"
                        ]
                    ]
                ),
            ),
            new Response(response: 404, description: "Not found board!!!"),
            new Response(response: 500, description: "Failed to update board!!!"),
        ],
    )]



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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $board = DB::table('boards')->where('id', $id)->first();

            if ($board == null) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found board!!!'
                ]);
            } else {
                $tmpBoard = new Board();
                $tmpBoard->title = ($request->title != null ? $request->title : $board->title);
                $tmpBoard->workspace_id = ($request->workspace_id != null ? $request->workspace_id : $board->workspace_id);
                $tmpBoard->closed = ($request->closed != null ? $request->closed : $board->closed);

                Board::where('id', $id)->update(
                    [
                        'title' => $tmpBoard->title,
                        'workspace_id' => $tmpBoard->workspace_id,
                        'closed' => $tmpBoard->closed
                    ]
                );
                $board = DB::table('boards')->where('id', $id)->first();
                return response()->json(
                    [
                        'code' => '200',
                        'message' => 'Update board succesfully!!',
                        'data' => $board
                    ]
                );
            }
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to update board!!!'
                ]
            );
        }
    }
    #[delete(
        path: "/board/{id}",
        operationId: "board_delete_by_ID",
        summary: "Delete data a board by ID",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int"),
                        ],
                        example: ["id" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Found board succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "board", properties: [], type: "object"),
                    ],
                    example: []
                ),
            ),
            new Response(response: 404, description: "Not found board!!!"),
            new Response(response: 500, description: "Failed to delete board!!!"),
        ],
    )]
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $board = DB::table('boards')->where('id', $id)->first();

            if ($board == null) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found board!!!'
                ]);
            } else {

                Board::where('id', $id)->delete();

                return response()->json(
                    [
                        'code' => '200',
                        'message' => 'Delete board succesfully!!'
                    ]
                );
            }
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to delete board!!!'
                ]
            );
        }
    }
}
