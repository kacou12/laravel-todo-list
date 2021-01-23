<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function affect(User $user , Todo $todo)
    {
        return in_array(Auth::id(), [$todo->affectedTo_id, $todo->affectedBy_id]) || $todo->affectedTo_id == 0;
        # code...
    }


    public function done(User $user , Todo $todo)
    {
        # code...
        //todo mmust be affected to user connected et lui seul peut le supprimer
        return $todo->affectedTo_id != 0 && Auth::id() == $todo->affectedTo_id;
    }

    public function edit(User $user , Todo $todo)
    {
        //auth connecte doit etre affecteur ou l'affecte pour editer
        return in_array(Auth::id(), [$todo->affectedTo_id, $todo->affectedBy_id]);
    }

    public function delete(User $user , Todo $todo)
    {
        # code...
        return in_array(Auth::id(), [$todo->affectedTo_id, $todo->affectedBy_id]);
    }
}
