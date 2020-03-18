<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{

    /**
     * Create a new Board
     * 
     * @param Request $request
     * @return Board $board;
     */
    public function new(Request $request)
    {
        $board = new Board;
        $board->title = $request->title;
        
        $board->save();
        
        return response()->json($board);
    }

    /**
     * List all boards actives
     * 
     * @param Request
     * @return Array $boards 
     */
    public function list(Request $request)
    {
        $boards = Board::where('archived_at')->get();
        return response()->json($boards);
    }

    /**
     * List one board active
     * 
     * @param Request
     * @return Array $boards 
     */
    public function details(Request $request, $id)
    {
        $board = Board::find($id);
        return response()->json($board);
    }

    /**
     * Delete a active Board
     *
     * @param  Request  $request
     * @return Board $board
     */
    public function done(Request $request, $id)
    {
        $board = Board::find($id);
        $board->archived_at = date("Y-m-d H:i:s");
        $board->save();
        return $board;
    }

    /**
     * Undelete a active Board
     *
     * @param  Request  $request
     * @return Board $board
     */
    public function undone(Request $request, $id)
    {
        $board = Board::find($id);
        $board->archived_at = NULL;
        $board->save();
        return $board;
    }
}