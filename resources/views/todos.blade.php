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
                                 {{-- Creee par --}}
                                Creee le {{ $todo->created_at->from() }} par 
                                @if($todo->creator_id == Auth::id())
                                    moi
                                @else
                                    {{ $todo->user->name }}
                                @endif
                               <p>
                                        {{-- affecte par --}}
                                    @if ($todo->affectedTo_id != 0)

                                    {{-- affecte a  --}}
                                    affecté a
                                    @if($todo->affectedTo->id == Auth::id())
                                        moi
                                    @else
                                        {{ $todo->affectedTo->name }}
                                    @endif
                                    
                                    par 
                                    @if($todo->affectedBy->id == Auth::id())
                                        moi
                                    @else
                                    {{ $todo->affectedBy->name }}
                                    @endif
                                    

                                    @else
                                        non Affecté
                                    
                                    @endif
                               </p>

                            </small>
                            

                            {{-- Information about ended time todo --}}
                            @if ($todo->done == 1)
                                <small>
                                    <p>
                                        terminée
                                        {{ $todo->updated_at->from() }} - en
                                        {{ $todo->updated_at->diffForHumans($todo->created_at, 1) }}

                                    </p>
                                </small>
                            @endif
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
                    {{-- can affecte si tache affect to user connected or not affected to any one    --}}                        
                    @can('affect',$todo)
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
                           
                    @elsecannot('affect',$todo)

                        <div class="dropdown open">
                            <button class="btn btn-secondary dropdown-toggle" disabled type="button" id="DropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Affecté a 
                                    </button>
                            <div class="dropdown-menu" aria-labelledby="DropdownMenuButton">
                                @foreach ($users as $user)
                                    <a class="dropdown-item" href="{{ route('affectedTo', [$todo->id , $user->id]) }}">{{ $user->name }}</a>
                                @endforeach
                            </div>
                        </div>

                    @endcan 
                    
                    {{-- FIN BUTTON AFFECT --}}

    
                    <!--done or undone -->
                    {{-- Done undone si tache non affectée ou tache for auth connected --}}                     
                    @can('done', $todo)
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
                        
                    @elsecannot('done', $todo)
                        @if($todo->done == 1)                            
                            <form action="{{ route('makeundone',$todo->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" disabled class="btn btn-warning mx-1" style="min-width: 90px">Undone</button>
                            </form>
                        @else
                            <form action="{{ route('makedone', $todo->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" disabled class="btn btn-success mx-1" style="min-width: 90px">Done</button>
                            </form>
                        @endif
                        
                    @endcan       
                    {{-- FIN BUTTON DONE UNDONE --}}  

                    {{-- Button editer --}}
                    @can('edit', $todo)                        
                        <a role="button" href="{{ route('todos.edit',  $todo->id) }}" class="btn btn-info mx-1" style="min-width: 90px">Editer</a>
                    @elsecannot('edit', $todo)
                        <a role="button" href="{{ route('todos.edit',  $todo->id) }}" class="btn btn-info mx-1 disabled" style="min-width: 90px">Editer</a>
                    @endcan

                    {{-- Btton delete --}}   
                    @can('delete', $todo)
                        <form action="{{ route('todos.destroy',  $todo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button role="button" class="btn btn-danger" style="min-width: 90px">Efacer</button>
                        </form>
                    @elsecannot('delete', $todo)
                        <form action="{{ route('todos.destroy',  $todo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button role="button" disabled class="btn btn-danger" style="min-width: 90px">Efacer</button>
                        </form>     
                    @endcan                   
                </div>
            </div>
    
        </div>
    @endforeach
        {{ $todos->links() }}

@endsection