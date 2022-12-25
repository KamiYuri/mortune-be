<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Workspace;

class WorkspaceController extends Controller
{
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req)
    {
        $id = $req->id;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        $name = $req->name;
        $description = $req->description;
        $created_at = now();
        $updated_at = now();
        $id = $req->id;
        DB::table('workspaces')
            ->where('id', $id)
            ->update(['name' => $name, 'description'=> $description, 'created_at'=> $created_at, 'updated_at'=> $updated_at]);

        //gui ve dl sau khi them
        $data = DB::table("workspaces")->get();
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        $id = $req->id;
        $deleted = DB::table('workspaces')->where('id', '=', $id)->delete();
        //gui ve dl sau khi them
        $data = DB::table("workspaces")->get();
        return response()->json($data);
    }
}
