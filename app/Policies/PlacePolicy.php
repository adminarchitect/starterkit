<?php

namespace App\Policies;

use App\Place;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

class PlacePolicy
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

//    /**
//     * @param  Authenticatable  $user
//     * @return bool
//     */
//    public function create(Authenticatable $user): bool
//    {
//        return $user->id === 1;
//    }
//
//    /**
//     * @param  Authenticatable  $user
//     * @param  Place  $place
//     * @return bool
//     */
//    public function update(Authenticatable $user, Place $place): bool
//    {
//        return $user->id === 1 && $place->id !== 2;
//    }
//
//    /**
//     * @param  Authenticatable  $user
//     * @param  Place  $place
//     * @return bool
//     */
//    public function delete(Authenticatable $user, Place $place): bool
//    {
//        return $this->update($user, $place);
//    }
}
