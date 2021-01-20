<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use App\Notifications\todoAffected;
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
        
        $todo = Todo::create([
            "titre"=> $request->titre,
            "description" => $request->description,
            'creator_id' =>Auth::id()
        ]);

        notify()->success("La todo <span class='bagde badge-dark'>#$todo->id</span> vient d'etre créee. ");
        return redirect()->route('todos.index');
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
        notify()->success("La todo <span class='bagde badge-dark'>#$todo->id</span> a bien été modifiée. ");
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
        $todo->delete();
        notify()->error("La todo <span class='bagde badge-dark'>#$todo->id</span> a bien été supprimée. ");
        return back();
    }
    /**
     * undone for see all todos whose are not done 
     */

    public function undone()
    {
        $users = User::all();
        # code...
        $todos =  Todo::where('done', 0)->orderby('id', 'DESC')->paginate(4);
        $number = Todo::where('done', 0)->count();
        
        return view('todos', compact('todos', "number", 'users'));
    }



    public function done()
    {
        $users = User::all();
        # code...
        $todos =  Todo::where('done', 1)->orderby('id', 'DESC')->paginate(4);
        $number = Todo::where('done', 1)->count();
        return view('todos', compact('todos', "number", 'users'));
    }

    public function makedone(Todo $todo){
        $todo->done = 1;
        $todo->update();

        notify()->success("La todo <span class='bagde badge-dark'>#$todo->id</span> est terminéé. ");

        return back();
    }

    public function makeundone(Todo $todo){
        $todo->done = 0;
        $todo->update();

        notify()->error("La todo <span class='bagde badge-dark'>#$todo->id</span>est en cours. ");

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
        $af = $todo->affectedTo->name;

        //$user->notify(new todoAffected($todo));

        notify()->error("La todo <span class='bagde badge-dark'>#$todo->id</span>a été affecté a <span class='bagde badge-dark'>$af</span>. ");
        
        return back();
    }
    public function test(){
        $user = User::find(6);
        dd($user->affectedTo);
        //return view('index', compact('user'));
    }
}
