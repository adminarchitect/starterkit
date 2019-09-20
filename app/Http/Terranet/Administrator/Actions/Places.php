<?php

namespace App\Http\Terranet\Administrator\Actions;

use App\Http\Terranet\Administrator\Actions\Handlers\HideItems;
use App\Http\Terranet\Administrator\Actions\Handlers\ShowItems;
use App\Http\Terranet\Administrator\Actions\Handlers\ToggleActivity;
use Terranet\Administrator\Services\CrudActions;

class Places extends CrudActions
{
    public function actions()
    {
        return [
            // CustomAction::class
            ToggleActivity::class,
        ];
    }

    public function batchActions()
    {
        return array_merge(
            parent::batchActions(),
            [
                ShowItems::class,
                HideItems::class,
                // CustomAction::class
            ]
        );
    }
}
