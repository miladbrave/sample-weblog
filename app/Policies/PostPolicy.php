<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        //
    }


    public function view(User $user, Post $post)
    {
        //
    }


    public function create(User $user)
    {
        return $user->role === User::AUTHOR;
    }


    public function update(User $user, Post $post)
    {

        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }


    public function delete(User $user, Post $post)
    {
        //
    }


    public function restore(User $user, Post $post)
    {
        //
    }


    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
