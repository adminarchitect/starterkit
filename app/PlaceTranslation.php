<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceTranslation extends Model
{
    protected $fillable = ['name', 'description'];

    public $timestamps = false;
}
