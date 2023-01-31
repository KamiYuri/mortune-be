<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;

use Illuminate\Support\Facades\DB;
use App\Models\CardList;
use App\Models\Card;
use App\Models\CardMember;

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
     * @return JsonResponse
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
     * @return JsonResponse
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

            $card_member = new CardMember;
            $card_member->member_id = auth()->id();
            $card_member->card_id = $newCard->id;
            $card_member->role = 1;
            $card_member->created_at = now();
            $card_member->updated_at = now();
            $card_member->save();

            return $this->success($newCard, 'Create new card successfully!');
        }catch(Exception $error){
            return $this->error("Error when create new card!", 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $card = Card::findOrFail($id);
            return $this->success($card, 'Found result for card!');
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
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try{
            $card = Card::where('id', $id)->first();
            if(is_null($card)){
                return $this->error('Not found result for card!', 401);
            }else{
                $card_member = CardMember::where('card_id', $id)->delete();
                $card->delete();
                return $this->success(null, 'Delete card successfully!');
            }
        }catch(Exception $error){
            return $this->error('Error when deleting card!', 500);
        }
    }

    public function getCardbyCardList(int $list_id){
        try{
            $card_list = CardList::where('id', $list_id)->first();
            $cards = Card::where('list_id', $list_id)->get();
            $card_list->cards = $cards;
            return $this->success($card_list, 'OK');
        }catch(Exception $error){
            return $this->error($error, 500);
        }

    }

    public function addMemberToCard(Request $request){
        try{
            if(is_null($request->card_id) || is_null($request->member_id)){
                return $this->error("Missing fields!", 401);
            }
            $user_id = $request->member_id;
            $card_id = $request->card_id;
            $card_mb = DB::table('card_member')->where('member_id', $user_id)->where('card_id', $card_id)
            ->first();

            if(!is_null($card_mb)){
                return $this->error('Member already in this card!', 402);
            }

            $card_member = new CardMember;
            $card_member->member_id = $user_id;
            $card_member->card_id = $card_id;
            $card_member->role = 2;
            $card_member->created_at = now();
            $card_member->updated_at = now();
            $card_member->save();

            return $this->success($card_member, 'OK');
        }catch(Exception $error){
            return $this->error($error, 500);
        }

    }
}
