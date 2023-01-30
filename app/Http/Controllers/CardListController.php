<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;

use Illuminate\Support\Facades\DB;
use App\Models\CardList;
use App\Models\Board;
use App\Models\Card;

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


class CardListController extends Controller
{
    
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #[OA\Get(
        path: "/card_list", operationId: "card list", summary: "Get all card list in the database",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            
                        ],
                        example: ''
                    ),
                )
            ]
        ),
        tags: ["CardList"],
        responses: [
            new Response(response: 200, description: "Get data card list successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "card_list", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                            new Property(property: "board_id", type: "id"),
                            new Property(property: "archived", type: "int"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "card_list" => [
                            "id" => 1,
                            "title" => "abc",
                            "board_id" => 1,
                            "archived" => 1,
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in get data workspace"),
        ],
    )]

    public function index()
    {
        return $this->success(CardList::all(), 'OK');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    #[Post(
        path: "/card_list", operationId: "cardListAdd", summary: "Add a card list",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "title", type: "string"),
                            new Property(property: "board_id", type: "int"),
                            new Property(property: "archived", type: "int"),
                        ],
                        example: ["title" => "do something", "board_id" => 4, "archived" => 0]
                    ),
                )
            ]
        ),
        tags: ["CardList"],
        responses: [
            new Response(response: 200, description: "Add data card list successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "response", properties: [
                            new Property(property: "code", type: "int"),
                            new Property(property: "message", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "response" => [
                            "code" => 200,
                            "message" => "Create card list successfully!"]
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
    public function store(Request $request)
    {
        //
        try{

            if(is_null($request->board_id) || is_null($request->title)){
                return $this->error('Missing field!', 401);
            }
            
            $card_list = CardList::where('board_id', $request->board_id)->where('title', $request->title)->first();
            if(!is_null($card_list)){
                return $this->error('Title already exists!', 401);
            }

            $newCardList = new CardList;
            $newCardList->title = $request->title;
            $newCardList->board_id = $request->board_id;
            $newCardList->archived = $request->archived;
            
            $newCardList->save();

            return response()->json(['code' => '200', 
                'message' => 'Create card list successfully!']);
            
        }catch(Exception $error){
            return $this->error('Error when creating list', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cards = Card::where('list_id', $id)->get();
        return $this->success($cards, 'OK');

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
        path: "/card_list/{id}", operationId: "cardListUpdate", summary: "Update card list",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string")
                        ],
                        example: [
                            "id" => 1,
                            "title" => "sone title"     
                        ]
                    ),
                )
            ]
        ),
        tags: ["CardList"],
        responses: [
            new Response(response: 200, description: "Update card list successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "card_list", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "title", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "card list" => [
                            "id" => 1,
                            "title" => "abc"
                        ]
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
    public function update(Request $request, $id)
    {
        $title = $request->title;
        if(is_null($title)){
            return $this->error('Missing fields!');
        }
        try{
            CardList::where('id', $id)->update(['title' => $title]);
            return response()->json(['code' => '200',
            'message' => 'Update card list successfully!']);
        }catch(Exception $error){
            return $this->error("Error when updating!", 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    #[OA\Delete(
        path: "/card_list/{id}", operationId: "cardListDelete", summary: "Delete a card list",
        requestBody: new RequestBody
        (
            content: [
            ]
        ),
        tags: ["CardList"],
        responses: [
            new Response(response: 200, description: "Add data card list successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "response", properties: [
                            new Property(property: "code", type: "int"),
                            new Property(property: "message", type: "string"),
                        ], type: "object")
                    ],
                    example:
                    [
                        "response" => [
                            "code" => 200,
                            "message" => "Delete card list successfully!"]
                    ]
                ),
            ),
            new Response(response: 500, description: "Error in add workspace"),
        ],
    )]

    public function destroy($id)
    {
        try{
            try{
                $cardList = DB::table('card_lists')->where('id', $id)->first();
            }catch(Exception $err){
                return $this->err("Card list with id ", $id, " doesn't exist!");
            }
            $cardList = CardList::where('id', $id)->delete();
            return response()->json(['code' => '200', 
                'message' => 'Delete card list successfully!']);
        } catch(Exception $error){
            return $this->error('Error when deleting card list!', 500);
        }
    }
}
