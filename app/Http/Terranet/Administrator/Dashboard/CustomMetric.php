<?php

namespace App\Http\Terranet\Administrator\Dashboard;

use App\Place;
use Terranet\Administrator\Dashboard\Panel;
use Terranet\Administrator\Traits\Stringify;

class CustomMetric extends Panel
{
    use Stringify;

    /**
     * @var Place
     */
    protected $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    /**
     * Widget contents
     *
     * @return mixed string|View
     */
    public function render()
    {
        return view('admin.dashboard.custom_metric')->with([
            'place' => $this->place,
        ]);
    }
}
