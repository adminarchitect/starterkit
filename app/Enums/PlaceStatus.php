<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Draft()
 * @method static static Approved()
 * @method static static Rejected()
 */
final class PlaceStatus extends Enum
{
    const PENDING = 0;
    const DRAFT = 1;
    const APPROVED = 2;
    const REJECTED = 3;
}
