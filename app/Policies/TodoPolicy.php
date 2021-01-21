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
    public function affect(Todo $todo)
    {
        return Auth::id() === $todo->affectedTo_id || $todo->affectedTo_id === 0;
        # code...
    }

    public function done(Todo $todo)
    {
        # code...
        return $todo->affectedTo_id != 0 && Auth::id() == $todo->affectedTo_id;
    }

    public function edit(Todo $todo)
    {

        return in_array(Auth::id(), [$todo->affectedTo_id, $todo->affectedBy_id]);
    }

    public function delete(Todo $todo)
    {
        # code...
        return $todo->affectedTo_id != 0 && Auth::id() == $todo->affectedTo_id;
    }
}
