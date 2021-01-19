@extends('layouts.layout')
    @section('content')
    <h4>Toutes les todos ({{ $number }})</h4>
    <!-- Affichage des contenus de la BD -->
    @foreach ($todos as $todo)        
        <div class="alert {{ $todo->done == 1 ? 'alert-primary' : 'alert-warning'}}" role="alert">
            <div class="row">
                    <div class="col-sm">
                        <p class="my-0">
                            <strong class="badge badge-dark">
                                #{{ $todo->id }}
                            </strong>
                            <small>
                                {{ dd($todo->affectedTo) }}
                               
                                
                            </small>
                        </p>
                        <details>
                            <summary>
                                <strong>{{ $todo->titre }}  @if ($todo->done == 1) <span class="badge badge-success">Done</span>@endif</strong>      
                            </summary>
                            <p>{{ $todo->description }}</p>
                        </details>
                    </div>
                
                <div class="col-sm form-inline justify-content-end">
                    <!--dropdown affecté -->
                    <div class="dropdown open">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="DropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                    Affecté a 
                                </button>
                        <div class="dropdown-menu" aria-labelledby="DropdownMenuButton">
                            @foreach ($users as $user)
                                <a class="dropdown-item" href="{{ route('affectedTo', [$todo->id , $user->id]) }}">{{ $user->name }}</a>
                            @endforeach
                        </div>
                    </div>
    
                    <!--done or undone -->
                    @if($todo->done == 1)                            
                        <form action="{{ route('makeundone',$todo->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning mx-1" style="min-width: 90px">Undone</button>
                        </form>
                    @else
                        <form action="{{ route('makedone', $todo->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success mx-1" style="min-width: 90px">Done</button>
                        </form>
                    @endif
                    {{-- Button editer --}}
                        <a role="button" href="{{ route('todos.edit',  $todo->id) }}" class="btn btn-info mx-1" style="min-width: 90px">Editer</a>
                    {{-- Btton delete --}}
                    <form action="{{ route('todos.destroy',  $todo->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button role="button" class="btn btn-danger" style="min-width: 90px">Efacer</button>
                    </form>
    
                </div>
            </div>
    
        </div>
    @endforeach
        {{ $todos->links() }}

@endsection