<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Document</title>
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
        @foreach ($todos as $todo)
            
            <div class="alert alert-primary" role="alert">
                <strong>{{ $todo->titre }}</strong>
                @if ($todo->done == 1) <span class="badge badge-success">Done</span>@endif
            </div>
            @endforeach
            {{ $todos->links() }}
    </main>
    
</body>
</html>l