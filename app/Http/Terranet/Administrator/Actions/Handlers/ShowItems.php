<?php

namespace App\Http\Terranet\Administrator\Actions\Handlers;

use App\Place;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Terranet\Administrator\AdminRequest;
use Terranet\Administrator\Traits\Actions\BatchSkeleton;
use Terranet\Administrator\Traits\Actions\Skeleton;

class ShowItems
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
                return $this->canTransform($place, $request) ? $place->actievate() : $place;
            });

        return $entity;
    }

    /**
     * @param  Eloquent  $entity
     * @param $collection
     * @return Collection
     */
    protected function fetchSelected(Eloquent $entity, $collection): Collection
    {
        return $entity->newQueryWithoutScopes()->find($collection);
    }

    /**
     * @param  Place  $place
     * @param  AdminRequest  $request
     * @return bool
     */
    protected function canTransform(Place $place, AdminRequest $request): bool
    {
        return $request->resource()->actions()->authorize('update', $place);
    }

    /**
     * @param  Eloquent|null  $model
     * @return string
     */
    public function icon(Eloquent $model = null): string
    {
        return 'fa-eye';
    }
}
