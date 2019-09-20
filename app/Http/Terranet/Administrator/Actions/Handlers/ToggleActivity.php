<?php

namespace App\Http\Terranet\Administrator\Actions\Handlers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User;
use Terranet\Administrator\Traits\Actions\ActionSkeleton;
use Terranet\Administrator\Traits\Actions\Skeleton;

class ToggleActivity
{
    use Skeleton, ActionSkeleton;

    /**
     * Update single entity.
     *
     * @param  Eloquent  $entity
     * @return mixed
     */
    public function handle(Eloquent $entity)
    {
        $entity->active = !$entity->active;
        $entity->save();

        return $entity;
    }

    /**
     * @param  User  $viewer
     * @param  Eloquent|null  $model
     * @return bool
     */
    public function authorize(User $viewer, Model $model = null)
    {
        return $viewer->id === 1 && $model->id !== 2;
    }

    /**
     * @param  Eloquent  $entity
     * @return string
     */
    public function name(Eloquent $entity)
    {
        return $entity->active ? 'Hide' : 'Show';
    }

    public function hideFromIndex(): bool
    {
        return true;
    }
}
