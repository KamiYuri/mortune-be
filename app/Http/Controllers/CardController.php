<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;

use Illuminate\Support\Facades\DB;
use App\Models\CardList;
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

class CardController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(Card::all(), 'OK');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(is_null($request->list_id) || is_null($request->title) || is_null($request->due) ||
        is_null($request->due_complete) || is_null($request->description)){
            return $this->error('Missing fields', 401);
        }

        $cardList = CardList::where('id', $request->list_id)->first();
        if(is_null($cardList)){
            return $this->error('List ID not exists!', 402);
        }
        $card = Card::where('title', $request->title)->first();
        if(!is_null($card)){
            return $this->error('Title already exists!', 403);
        }
        try{
            $newCard = new Card;
            $newCard->list_id = $request->list_id;
            $newCard->archived = $request->archived;
            $newCard->description = $request->description;
            $newCard->due = $request->due;
            $newCard->due_complete = $request->due_complete;
            $newCard->title = $request->title;

            $newCard->save();

            return $this->success($newCard, 'Create new card successfully!');
        }catch(Exception $error){
            return $this->error("Error when create new card!", 500);
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
        try {
            $card = Card::where('id', $id)->first();
            if(is_null($card)){
                return $this->error('Not found result for card!', 401);
            }else{
                return $this->success($card, 'Found result for card!');
            }
        }catch(Exception $error){
            return $this->error("Error when display card!", 500);
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
        try{
            $card = Card::where('id', $id)->first();
            if(is_null($card)){
                return $this->error('Not found result for card!', 401);
            }else{
                $description = $request->description;
                $due = $request->due;
                $due_complete = $request->due_complete;
                $title = $request->title;

                if(!is_null($title)){
                    $card->update(['title' => $title]);
                }
                if(!is_null($description)){
                    $card->update(['description' => $description]);
                }
                if(!is_null($due)){
                    $card->update(['due' => $due]);
                }
                if(!is_null($due_complete)){
                    $card->update(['due_complete' => $due_complete]);
                }

                return $this->success($card, 'Updating card successfully!');
                
            }
        }catch(Exception $error){
            return $this->error("Error when updating card!", 500);
        }
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
