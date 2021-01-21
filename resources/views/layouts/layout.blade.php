
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title> Laravel todo app</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sticky-footer-navbar/">


    <style>
     summary:focus {
        outline: none !important;
    }

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="sticky-footer-navbar.css" rel="stylesheet">
    @notify_css
  </head>
  <body class="d-flex flex-column h-100">
    
    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Laravel Todo List</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
              <li class="nav-item active">
                <a class="nav-link" aria-current="page" href="{{ route('todos.create') }}">Ajouter une todo</a>
              </li>
              <li class="nav-link">
                <span style="color: white;">{{ auth()->user()->name }}</span>
              </li>
              @auth
                <!-- ICON -->
                <div class="dropdown nav-button notifications-button hidden-sm-down">
  
                    <a class="btn btn-primary dropdown-toggle" href="#" id="notifications-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i id="notificationsIcon" aria-hidden="true"></i>
                        <svg class="bi bi-bell-fill" width="1em" height="1em" viewBox="0 0 16 16"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8 16a2 2 0 002-2H6a2 2 0 002 2zm.995-14.901a1 1 0 10-1.99 0A5.002 5.002 0 003 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                        </svg>
                        <span id="notificationsBadge" class="badge badge-danger"><i
                                class="fa fa-spinner fa-pulse fa-fw"
                                aria-hidden="true">{{ count(Auth::User()->unreadNotifications) }}</i></span>
                    </a>
  
                    <!-- NOTIFICATIONS -->
                    <div class="dropdown-menu notification-dropdown-menu" aria-labelledby="notifications-dropdown"
                        style="min-width: 360px; max-width: 360px;">
                        <h6 class="dropdown-header">Notifications</h6>
  
                        {{--  <!-- CHARGEMENT -->
                            <a id="notificationsLoader" class="dropdown-item dropdown-notification" href="#">
                                <p class="notification-solo text-center"><i id="notificationsIcon"
                                        class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i> Chargement des
                                    dernières notifications...</p>
                            </a>  --}}
                        @if(count(Auth::User()->unreadNotifications) > 0)
                        <div id="notificationsContainer" class="notifications-container">
                            @foreach (Auth::User()->unreadNotifications as $notification)
                            {{--  <a class="dropdown-item dropdown-notification" href="{{href}}"> --}}
                            {{--  <div class="notification-read">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>  --}}
                            <div class="notifications-body">
                                <p class="notification-texte mx-1">
                                    <small><span
                                            class="badge badge-pill badge-dark">#{{ $notification->data['todo_id'] }}</span>
                                        {{ $notification->data['affected_by'] }}
                                        t'a affecté la todo {{ $notification->data['todo_name'] }}</small></p>
                            </div>
                            {{ Auth::User()->unreadNotifications->markAsRead() }}
                            @endforeach
  
                        </div>
                        @else
                        <!-- AUCUNE NOTIFICATION -->
                        <a id="notificationAucune" class="dropdown-item dropdown-notification" href="#">
                            <p class="notification-solo text-center">Aucune nouvelle notification</p>
                        </a>
                        @endif
                        {{--  <!-- TOUTES -->
                            <a class="dropdown-item dropdown-notification-all" href="#">
                                Voir toutes les notifications
                            </a>  --}}
  
                    </div>
  
                </div>
              @endauth
              <li class="nav-item ml-2">
                <form action="/logout" method="post">
                  @csrf
                  <button class="nav-link btn btn-secondary">Deconnexion</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
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
        @yield('content')
    </main>

    
    <script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>  
  </body>
  @notify_js
  @notify_render
</html>






