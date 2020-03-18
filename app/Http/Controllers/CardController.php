<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{


    /**
     * Create a new Card
     * 
     * @param Request $request
     * @return Card $card;
     */
    public function new(Request $request)
    {
        if( empty($request->title) || empty($request->content) || empty($request->label) || empty($request->created_by) )
        {
            return response()->json(array(
                "error" => "Verifique os campos digitados.",
                "required" => array(
                    'title' => $request->title,
                    'content' => $request->content,
                    'label' => $request->label,
                    'created_by' => $request->created_by,
                )
            ));
        }
        $card = new Card;
        $card->title = $request->title;
        $card->content = $request->content;
        $card->label = $request->label;
        $card->created_by = $request->created_by;
        
        $card->save();
        
        return response()->json($card);
    }

    /**
     * List all boards actives
     * 
     * @param Request
     * @return Array $boards 
     */
    public function list(Request $request)
    {
        $boards = Card::all();
        return response()->json($boards);
    }

    /**
     * List one card active
     * 
     * @param Request
     * @return Array $boards 
     */
    public function details(Request $request, $id)
    {
        $card = Card::find($id);
        return response()->json($card);
    }

    /**
     * Delete a active Card
     *
     * @param  Request  $request
     * @return Card $card
     */
    public function done(Request $request, $id)
    {
        $card = Card::find($id);
        $card->list_state = "FRIDGE";
        $card->save();
        return $card;
    }

    /**
     * Move the a active Card, when its possible
     *
     * @param  Request  $request
     * @return Card $card
     */
    public function move(Request $request, $id)
    {
        $card = Card::find($id);
        $req = $request->list_state ?? $card->list_state;
        $new_state = array(
            'TODO' => 'DOING',
            'DOING' => 'DONE',
            'DONE'  => false,
            'FRIDGE' => 'TODO'
        );
        if($card->list_state != "FRIDGE" && $new_state[$req] !== false) {
            $card->list_state = $new_state[$req];
            $card->save();
        }

        return $card;
    }

    /**
     * Undelete a active Card
     *
     * @param  Request  $request
     * @return Card $card
     */
    public function undone(Request $request, $id)
    {
        $card = Card::find($id);
        $card->list_state = "TODO";
        $card->save();
        return $card;
    }
}