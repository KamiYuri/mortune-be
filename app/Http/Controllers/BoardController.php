<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\CardList;
use App\Models\BoardMember;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes as OA;
use App\Traits\HttpResponses;

class BoardController extends Controller
{

    use HttpResponses;
    // index
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
                    example: []
                ),
            ),
            new Response(response: 500, description: "Failed to get data board!!!"),
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
            $user = auth()->user();
            $boards = $user->boards;
            return $this->success($boards);
        } catch (Exception $error) {
            return $this->error($error, 404);
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
    // end create
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


    // show

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
            $data = DB::table('boards')->where('id', $id)->first();
        } catch (Exception $err) {
            return response()->json([
                'code' => '500',
                'message' => 'Failed to found board!!!'
            ]);
        }

        if ($data != null) {
            return response()->json([
                'code' => '200',
                'message' => 'Found board succesfully!!',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'code' => '404',
                'message' => 'Not found board!!!'
            ]);
        }
    }

    // end show

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


    // update

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
                $data = DB::table('boards')->where('id', $id)->first();
                return response()->json(
                    [
                        'code' => '200',
                        'message' => 'Update board succesfully!!',
                        'data' => $data
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

    // end update

    // destroy

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
            new Response(response: 200, description: "Delete board succesfully!!"),
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
                BoardMember::where('board_id', $id)->delete();

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

    // end destroy

    // boards_of_user

    #[post(
        path: "/board/boards_of_user/{id_user}",
        operationId: "boards_of_user",
        summary: "Get boards of user",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id_user", type: "int"),
                        ],
                        example: ["id_user" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get boards of user succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "data", properties: [
                            new Property(property: "board_id", type: "int"),
                            new Property(property: "role", type: "int"),
                        ], type: "object"),
                    ],
                    example: [
                        "payload" => [
                            "board_id" => 1,
                            "role" => 1,
                        ]
                    ]
                ),
            ),
            new Response(response: 400, description: "Parameter type is invalid!!!"),
            new Response(response: 404, description: "Not found user!!!"),
            new Response(response: 500, description: "Failed to get data!!!"),
        ],
    )]
    public function boards_of_user($id_user)
    {
        try {
            if (!is_numeric($id_user)) {
                return response()->json([
                    'code' => '400',
                    'message' => 'Parameter type is invalid!!!'
                ]);
            }

            $user = DB::table('users')->where('id', $id_user)->first();
            if ($user == null) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found user!!!'
                ]);
            } else {
                $data  = DB::table('board_member')
                    ->select('board_id', 'role')
                    ->where('member_id', $id_user)
                    ->get();

                return response()->json(
                    [
                        'code' => '200',
                        'message' => 'Get boards of user succesfully',
                        'data' => $data
                    ]
                );
            }
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to get data!!!'
                ]
            );
        }
    }

    // end boards_of_user

    // get membership of board
    #[post(
        path: "/board/get_membership_of_board/{id_board}",
        operationId: "get_membership_of_board",
        summary: "Get membership of board",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id_board", type: "int"),
                        ],
                        example: ["id_board" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get membership of board succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "data", properties: [
                            new Property(property: "member_id", type: "int"),
                            new Property(property: "role", type: "int")
                        ], type: "object"),
                    ],
                    example: [
                        "payload" => [
                            "member_id" => 1,
                            "role" => 1,
                        ]
                    ]
                ),
            ),
            new Response(response: 400, description: "Parameter type is invalid!!!"),
            new Response(response: 404, description: "Not found board!!!"),
            new Response(response: 500, description: "Failed to get data!!!"),
        ],
    )]
    public function get_membership_of_board ($id_board)
    {
        try {
            if (!is_numeric($id_board)) {
                return response()->json([
                    'code' => '400',
                    'message' => 'Parameter type is invalid!!!'
                ]);
            }

            if (DB::table('boards')->where('id', $id_board)->first()==null) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found board!!!'
                ]);
            } else {
                $data  = DB::table('board_member')
                    ->select('member_id', 'role')
                    ->where('board_id', $id_board)
                    ->get();

                return response()->json(
                    [
                        'code' => '200',
                        'message' => 'Get membership of board succesfully',
                        'data' => $data
                    ]
                );
            }
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to get data!!!'
                ]
            );
        }
    }

    // end get membership of board


    // boards_with_workspace_of_user
    #[post(
        path: "/board/boards_with_workspace_of_user/{id_user}",
        operationId: "boards_with_workspace_of_user",
        summary: "Get boards with workspace of user",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id_user", type: "int"),
                        ],
                        example: ["id_user" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get cards in board of user succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "data", properties: [
                            new Property(property: "board_id", type: "int"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "role", type: "int"),
                            new Property(property: "closed", type: "int"),
                        ], type: "object"),
                    ],
                    example: [
                        "payload" => [
                            "board_id" => 1,
                            "workspace_id" => 1,
                            "title" => "postx",
                            "role" => 1,
                            "closed" => 0,
                        ]
                    ]
                ),
            ),
            new Response(response: 400, description: "Parameter type is invalid!!!"),
            new Response(response: 404, description: "Not found user!!!"),
            new Response(response: 500, description: "Failed to get data!!!"),
        ],
    )]
    public function boards_with_workspace_of_user($id_user)
    {
        try {
            if (!is_numeric($id_user)) {
                return response()->json([
                    'code' => '400',
                    'message' => 'Parameter type is invalid!!!'
                ]);
            }

            $user = DB::table('users')->where('id', $id_user)->first();
            if ($user == null) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found user!!!'
                ]);
            } else {
                $data = DB::table('board_member')
                    ->select('*')
                    ->where('member_id', $id_user)
                    ->join('boards', 'boards.id', '=', 'board_member.board_id')
                    ->get();

                return $this->success($data);
            }
        } catch (Exception $error) {
            return $this->error('Failed to get data!', 500);
        }
    }

    // end boards_with_workspace_of_user

    // boards_in_workspace_of_user
    #[post(
        path: "/board/boards_in_workspace_of_user/{id_user}/{id_workspace}",
        operationId: "boards_in_workspace_of_user",
        summary: "Get boards in workspace of user",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id_board", type: "int"),
                            new Property(property: "id_workspace", type: "int"),
                        ],
                        example: ["id_board" => 1,"id_workspace" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get cards in board of user succesfully!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "data", properties: [
                            new Property(property: "board_id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "role", type: "int"),
                            new Property(property: "closed", type: "int"),
                        ], type: "object"),
                    ],
                    example: [
                        "payload" => [
                            "board_id" => 1,
                            "title" => "postx",
                            "role" => 1,
                            "closed" => 0,
                        ]
                    ]
                ),
            ),
            new Response(response: 205, description: "User is not member of workspace"),
            new Response(response: 400, description: "Parameter type is invalid!!!"),
            new Response(response: 404_1, description: "Not found user!!!"),
            new Response(response: 404_2, description: "Not found workspace!!!"),
            new Response(response: 500, description: "Failed to get data!!!"),
        ],
    )]
    public function boards_in_workspace_of_user($workspace_id)
    {
        try {
            $user = auth()->user();
            $boards = $user->boards->where("workspace_id", $workspace_id);

            return $this->success($boards);
        } catch (Exception $error) {
            return $this->error($error, 404);
        }
    }
    // end boards_in_workspace_of_user

    // getWorkspaceByBoard
    #[post(
        path: "/board/getWorkspaceByBoard/{id_board}",
        operationId: "getWorkspaceByBoard",
        summary: "Get Workspace By Board",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id_board", type: "int"),
                        ],
                        example: ["id_board" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get workspace by board succesfully!!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "payload", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                            new Property(property: "workspace", properties: [
                                new Property(property: "id", type: "int"),
                                new Property(property: "name", type: "string"),
                                new Property(property: "description", type: "string"),
                                new Property(property: "updated_at", type: "string"),
                                new Property(property: "created_at", type: "string"),
                            ], type: "object"),
                        ], type: "object"),
                    ],
                    example: [
                        "payload" => [
                            "id" => 1,
                            "title" => "postx",
                            "workspace_id" => 1,
                            "closed" => 0,
                            "created_at" => "2023-01-29T16:03:21.000000Z",
                            "updated_at" => "2023-01-29T16:03:21.000000Z",
                            "members"  => [
                                [
                                    "id" => 1,
                                    "name" => "eos",
                                    "description" => "Incidunt molestias molestiae repellendus illum rerum sint exercitationem exercitationem",
                                    "created_at" => "2023-01-29T16:03:21.000000Z",
                                    "updated_at" => "2023-01-29T16:03:21.000000Z",
                                ]
                            ]
                        ]
                    ]
                ),
            ),
            new Response(response: 400, description: "Paramater type is invalid!!!"),
            new Response(response: 404, description: "Not found board!!!"),
            new Response(response: 500, description: "Failed to get workspace by board!!!"),
        ],
    )]
    public function getWorkspaceByBoard($id_board)
    {
        try {
            if (!is_numeric($id_board))
                return response()->json([
                    'code' => '400',
                    'message' => 'Parameter type is invalid!!!'
                ]);


            if (DB::table('boards')->where('id', $id_board)->first() == null){
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found board!!!'
                ]);
            }

            $workspace = Board::with("workspace")->find($id_board)->toArray();

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'Get workspace by board succesfully!!!',
                    'payload' => $workspace
                ]
            );
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to get workspace by board!!!'
                ]
            );
        }
    }
    // end getWorkspaceByBoard

    // getCardListsByBoard
    #[post(
        path: "/board/getCardListsByBoard/{id_board}",
        operationId: "getCardListsByBoard",
        summary: "Get Cardlist By Board",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id_board", type: "int"),
                        ],
                        example: ["id_board" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get cardlists by board succesfully!!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "payload", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                            new Property(property: "card_lists", properties: [
                                new Property(property: "id", type: "int"),
                                new Property(property: "title", type: "string"),
                                new Property(property: "board_id", type: "int"),
                                new Property(property: "archived", type: "int"),
                                new Property(property: "updated_at", type: "string"),
                                new Property(property: "created_at", type: "string"),
                            ], type: "object"),
                        ], type: "object"),
                    ],
                    example: [
                        "payload" => [
                            "id" => 1,
                            "title" => "postx",
                            "workspace_id" => 1,
                            "closed" => 0,
                            "created_at" => "2023-01-29T16:03:21.000000Z",
                            "updated_at" => "2023-01-29T16:03:21.000000Z",
                            "members"  => [
                                [
                                    "id" => 1,
                                    "title" => "sit",
                                    "board_id" => 1,
                                    "archived" => 0,
                                    "created_at" => "2023-01-29T16:03:21.000000Z",
                                    "updated_at" => "2023-01-29T16:03:21.000000Z",
                                ]
                            ]
                        ]
                    ]
                ),
            ),
            new Response(response: 400, description: "Paramater type is invalid!!!"),
            new Response(response: 404, description: "Not found board!!!"),
            new Response(response: 500, description: "Failed to get cardlists by board!!!"),
        ],
    )]
    public function getCardListsByBoard($id_board)
    {
        try {
            if (!is_numeric($id_board))
                return response()->json([
                    'code' => '400',
                    'message' => 'Parameter type is invalid!!!'
                ]);


            if (DB::table('boards')->where('id', $id_board)->first() == null){
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found board!!!'
                ]);
            }

            $cardLists = Board::with("cardLists")->find($id_board)->toArray();

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'Get cardlists by board succesfully!!!',
                    'payload' => $cardLists
                ]
            );
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to get cardlists by board!!!'
                ]
            );
        }
    }
    // end getCardListsByBoard



    // getMembersByBoard
    #[post(
        path: "/board/getMembersByBoard/{id_board}",
        operationId: "getMembersByBoard",
        summary: "Get Members By Board",
        requestBody: new RequestBody(
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id_board", type: "int"),
                        ],
                        example: ["id_board" => 1]
                    ),
                )
            ]
        ),
        tags: ["Board"],
        responses: [
            new Response(
                response: 200,
                description: "Get members by board succesfully!!!",
                content: new JsonContent(
                    properties: [
                        new Property(property: "payload", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "workspace_id", type: "int"),
                            new Property(property: "closed", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                            new Property(property: "members", properties: [
                                new Property(property: "id", type: "int"),
                                new Property(property: "username", type: "string"),
                                new Property(property: "password", type: "int"),
                                new Property(property: "email", type: "int"),
                                new Property(property: "updated_at", type: "string"),
                                new Property(property: "created_at", type: "string"),
                                new Property(property: "pivot", properties: [
                                    new Property(property: "id", type: "int"),
                                    new Property(property: "board_id", type: "int"),
                                    new Property(property: "member_id", type: "int"),
                                    new Property(property: "role", type: "int"),
                                ], type: "object"),
                            ], type: "object"),
                        ], type: "object"),
                    ],
                    example: [
                        "payload" => [
                            "id" => 1,
                            "title" => "postx",
                            "workspace_id" => 1,
                            "closed" => 0,
                            "created_at" => "2023-01-29T16:03:21.000000Z",
                            "updated_at" => "2023-01-29T16:03:21.000000Z",
                            "members"  => [
                                [
                                    "id" => 1,
                                    "username" => "steuber.garnet",
                                    "password" => '$2y$10\$XrPo.eAKaUNeZ3elope57.XD11J611nOPNumpKZzcdza2eR7NeaAm',
                                    "email" => "reichel.trisha@example.net",
                                    "created_at" => "2023-01-29T16:03:21.000000Z",
                                    "updated_at" => "2023-01-29T16:03:21.000000Z",
                                    "pivot" => [
                                        "board_id" => 1,
                                        "member_id" => 1,
                                        "role" => 1
                                    ]
                                ]
                            ]
                        ]
                    ]
                ),
            ),
            new Response(response: 400, description: "Paramater type is invalid!!!"),
            new Response(response: 404, description: "Not found board!!!"),
            new Response(response: 500, description: "Failed to get members by board!!!"),
        ],
    )]
    public function getMembersByBoard($id_board)
    {
        try {
            if (!is_numeric($id_board))
                return response()->json([
                    'code' => '400',
                    'message' => 'Parameter type is invalid!!!'
                ]);


            if (DB::table('boards')->where('id', $id_board)->first() == null){
                return response()->json([
                    'code' => '404',
                    'message' => 'Not found board!!!'
                ]);
            }

            $members = Board::with("members")->find($id_board)->toArray();

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'Get members by board succesfully!!!',
                    'payload' => $members
                ]
            );
        } catch (Exception $error) {
            return response()->json(
                [
                    'code' => '500',
                    'message' => 'Failed to get members by board!!!'
                ]
            );
        }
    }
    // end getMembersByBoard

    public function addMemberToBoard(Request $request){
        try{
            if(is_null($request->board_id) || is_null($request->member_id)){
                return $this->error("Missing fields!", 401);
            }
            $user_id = $request->member_id;
            $board_id = $request->board_id;
            $board_mb = DB::table('board_member')->where('member_id', $user_id)->where('board_id', $board_id)
            ->first();

            if(!is_null($board_mb)){
                return $this->error('Member already in this board!', 402);
            }

            $board_member = new BoardMember;
            $board_member->member_id = $user_id;
            $board_member->board_id = $board_id;
            $board_member->role = 2;
            $board_member->created_at = now();
            $board_member->updated_at = now();
            $board_member->save();

            return $this->success($board_member, 'OK');
        }catch(Exception $error){
            return $this->error($error, 500);
        }

    }
}
