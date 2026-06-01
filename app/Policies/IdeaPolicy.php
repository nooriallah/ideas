<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdeaPolicy
{
//    Evey user should see only its own Idea
public function modify(User $user, Idea $idea) {
    return $idea->user()->is($user);
}
}
