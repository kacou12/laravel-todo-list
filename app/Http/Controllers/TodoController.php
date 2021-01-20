<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $users = User::all();
        $todos =  Todo::where('affectedTo_id',Auth::id())->paginate(5);
        $number = Todo::where('affectedTo_id',Auth::id())->count();
        return view('todos', compact('todos', 'number', 'users'));
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
            'creator_id' =>Auth::id(),
        ]);


        return redirect()->route('todos.index');/*view("todos", compact('todos', "number"))*/;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        if (!isset($request->done)){
            
            $todo->update([$request->all(), $todo->done = 0]);
        }else{

            $todo->update($request->all());
        }
        
        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo = $todo->delete();
        return back()->with("del_success", 'La todo a bien été Supprimée');
    }
    /**
     * undone for see all todos whose are not done 
     */

    public function undone()
    {
        $users = User::all();
        # code...
        $todos =  Todo::where('done', 0)->paginate(5);
        $number = Todo::where('done', 0)->count();
        return view('todos', compact('todos', "number", 'users'));
    }

    /**
     * undone for see all todos whose are  done 
     */

    public function done()
    {
        $users = User::all();
        # code...
        $todos =  Todo::where('done', 1)->paginate(5);
        $number = Todo::where('done', 1)->count();
        return view('todos', compact('todos', "number", 'users'));
    }

    public function makedone(Todo $todo){
        $todo->done = 1;
        $todo->update();

        return back();
    }

    public function makeundone(Todo $todo){
        $todo->done = 0;
        $todo->update();

        return back();
    }

    /**
     * Affected $todo->id any user 
     */

    public function affectedTo(todo $todo, user $user)
    {
        $todo->affectedTo_id = $user->id;
        $todo->affectedBy_id = Auth::id();

        $todo->update(); 
        
        return back();
    }
}
