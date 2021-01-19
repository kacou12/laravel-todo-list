<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Document</title>
    <style>
        .right{
            float: right;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <a name="" id="" class="btn btn-primary" href="{{ route('dashboard') }}" role="button">Retour</a>
    <main>
        <div class="header">
            <a class="btn btn-primary" href="{{ route('todos.create') }}" role="btn">
                <strong>Ajouter une todo</strong>
            </a>
            @if (Route::is('todos.undone'))
                <a class="btn btn-secondary" href="{{ route('todos.index') }}" role="btn">
                    <strong>Voir toutes les todos</strong>
                </a>
                <a class="btn btn-success" href="{{ route('todos.done') }}" role="btn">
                    <strong>Voir les todos terminées</strong>
                </a>

            @elseif (Route::is('todos.done'))
                <a class="btn btn-success" href="{{ route('todos.index') }}" role="btn">
                    <strong>Voir toutes les todos</strong>
                </a>
                <a class="btn btn-warning" href="{{ route('todos.undone') }}" role="btn">
                    <strong>Voir les todos non terminées</strong>
                </a>
            
            @else
                <a class="btn btn-success" href="{{ route('todos.done') }}" role="btn">
                    <strong>Voir les todos terminées</strong>
                </a>
                <a class="btn btn-warning" href="{{ route('todos.undone') }}" role="btn">
                    <strong>Voir les todos non terminées</strong>
                </a>

            @endif
        </div>
        <h4>Toutes les todos ({{ $number }})</h4>
        <!-- Affichage des contenus de la BD -->
        @foreach ($todos as $todo)        
            <div class="alert {{ $todo->done == 1 ? 'alert-primary' : 'alert-warning'}}" role="alert">
                    <div class="row">
                        <div class="col-sm">
                            <strong>{{ $todo->titre }}  @if ($todo->done == 1) <span class="badge badge-success">Done</span>@endif</strong>      
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
    </main>
    
</body>
</html>l