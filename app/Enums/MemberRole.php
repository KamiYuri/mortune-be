<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

///**
// * @method static static Owner()
// * @method static static Member()
// */
final class MemberRole extends Enum
{
    const Owner = 1;
    const Member = 2;
}
