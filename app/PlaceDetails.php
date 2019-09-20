<?php

namespace App;

use App\Enums\PlaceStatus;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;

class PlaceDetails extends Model
{
    use CastsEnums;

    protected $fillable = [
        'description',
        'type',
        'status',
        'phone',
        'email',
        'web_site',
        /*'data', 'location',*/
        'foundation_date',
    ];

    public $timestamps = false;

    /** @var array */
    protected $casts = [
        'data' => 'json',
        'status' => 'int',
    ];

    /** @var array */
    protected $enumCasts = [
        'status' => PlaceStatus::class,
    ];

    /** @var array */
    protected $dates = ['foundation_date'];
}
