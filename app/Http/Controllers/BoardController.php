<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Exception;

class BoardController extends Controller
{
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
