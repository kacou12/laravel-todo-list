<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Edit todo </title>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Modification de la Todo <span class="badge badge-dark">{{ $todo->id }}</span></h4>
        </div>
        <div class="card-body">
            <form action="{{ route('todos.update', $todo->id) }}" method='POST' class="col s12">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="input-field col s6">
                    <input id="input_text" type="text" name ="titre" value="{{ old('titre', $todo->titre) }}" data-length="10">
                    <label for="input_text">Titre</label>
                  </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                      <textarea id="textarea2" class="materialize-textarea"  name="description" data-length="120">{{ $todo->description }}</textarea>
                      <label for="textarea2">Description</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="done" id="done" value="1" class="form-check-input" {{ $todo->done == 1 ? 'checked': '' }}>
                        <label for="done" class="form-check-label">Done</label>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Modifier</button>
            </form>
        </div>  
    </div>
    
</body>
</html>