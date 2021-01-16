<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $todos =  Todo::latest()->paginate(5);
        $number = Todo::all()->count();
        return view('todos', compact('todos', 'number'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("create");
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
        $request->validate([
            "titre"=> 'required|bail|string|max:100',
            "description" => 'required|string|bail|max:500'
        ]);
        
        Todo::create([
            "titre"=> $request->titre,
            "description" => $request->description,
        ]);

        $todos =  Todo::paginate(5);
        $number = Todo::all()->count();

        return redirect()->route('todos.index');/*view("todos", compact('todos', "number"))*/;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $todo = Todo::find($id);
        return view('edit', compact('todo'));
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
        //
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
        $todo = Todo::find($id)->delete();
        return back()->with("del_success", 'La todo a bien été Supprimée');
    }
    /**
     * undone for see all todos whose are not done 
     */

    public function undone()
    {
        # code...
        $todos =  Todo::where('done', 0)->paginate(5);
        $number = Todo::where('done', 0)->count();
        return view('todos', compact('todos', "number"));
    }

    /**
     * undone for see all todos whose are  done 
     */

    public function done()
    {
        # code...
        $todos =  Todo::where('done', 1)->paginate(5);
        $number = Todo::where('done', 1)->count();
        return view('todos', compact('todos', "number"));
    }

    public function makedone($id){
        $todo = Todo::find($id);
        $todo->done = 1;
        $todo->save();

        return redirect()->route('todos.index');
    }

    public function makeundone($id){
        $todo = Todo::find($id);
        $todo->done = 0;
        $todo->save();

        return redirect()->route('todos.index');
    }
}
