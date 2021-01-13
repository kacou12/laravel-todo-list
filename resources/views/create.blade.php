<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <!-- Compiled and minified JavaScript -->
    <script src="{{ asset('js/materialize.min.js') }}"></script>

    <title>Creation de todo</title>
    <style>
      .forms_create{
        width: 50%;
        margin: auto;
      }
    </style>
</head>
<body>
      <div class="row forms_create">
        <h4>Creation d'une Todo</h4>
        <form action="{{ route('todos.store') }}" method='POST' class="col s12">
          @csrf
          <div class="row">
            <div class="input-field col s6">
              <input id="input_text" type="text" name ="titre" data-length="10">
              <label for="input_text">Titre</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="textarea2" class="materialize-textarea" name="description" data-length="120"></textarea>
              <label for="textarea2">Description</label>
            </div>
          </div>
          <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
        </form>
      </div>
  <script>
     $(document).ready(function() {
      $('input#input_text, textarea#textarea2').characterCounter();
    });   
  </script>
</body>
</html>