<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Todo::all();
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required|max:255',


        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->status = $request->status;
        $todo->from = $request->from ?? '';
        $todo->to = $request->to ?? '';
        $todo->save();

        return response()->json([
            'success' => true,
            'message' => 'Todo created successfully',
            'data' => $todo
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Todo::find($id);
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
        if (Todo::where('id', $id)->exists()) {
            $todo = Todo::find($id);
            $todo->title = is_null($request->title) ? $todo->title : $request->title;
            $todo->description = is_null($request->description) ? $todo->description : $request->description;
            $todo->status = is_null($request->status) ? $todo->status : $request->status;
            $todo->from = is_null($request->from) ? $todo->from : $request->from;
            $todo->to = is_null($request->to) ? $todo->to : $request->to;
            $todo->save();
            return response()->json([
                "message" => "Todo updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Todo not found"
            ], 404);
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
        if (Todo::where('id', $id)->exists()) {
            $todo = Todo::find($id);
            $todo->delete();
            return response()->json([
                "message" => "Todo deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Todo not found"
            ], 404);
        }
    }
}
