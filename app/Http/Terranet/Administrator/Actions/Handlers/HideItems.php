<?php

namespace App\Http\Terranet\Administrator\Actions\Handlers;

use App\Place;
use Terranet\Administrator\AdminRequest;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Terranet\Administrator\Traits\Actions\BatchSkeleton;
use Terranet\Administrator\Traits\Actions\Skeleton;

class HideItems extends ShowItems
{
    use Skeleton, BatchSkeleton;

    /**
     * Perform a batch action.
     *
     * @param  Eloquent  $entity
     * @param  AdminRequest  $request
     * @return mixed
     */
    public function handle(Eloquent $entity, AdminRequest $request)
    {
        $collection = $request->get('collection');

        $this->fetchSelected($entity, $collection)
            ->each(function (Place $place) use ($request) {
                return $this->canTransform($place, $request) ? $place->deactivate() : $place;
            });

        return $entity;
    }

    /**
     * @param  Eloquent|null  $model
     * @return string
     */
    public function icon(Eloquent $model = null): string
    {
        return 'fa-eye-slash';
    }
}
