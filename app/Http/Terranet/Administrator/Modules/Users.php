<?php

namespace App\Http\Terranet\Administrator\Modules;

use Terranet\Administrator\Collection\Mutable;
use Terranet\Administrator\Filter\Text;
use Terranet\Administrator\Modules\Users as CoreUsersModule;

/**
 * Administrator Users Module.
 */
class Users extends CoreUsersModule
{
    public function filters(): Mutable
    {
        return $this->scaffoldFilters()
//            ->update('email', function(Text $text) {
//                return $text->enableModes();
//            })
            ;
    }
}
