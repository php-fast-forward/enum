<?php

declare(strict_types=1);

require $argv[1] ?? dirname(__DIR__, 4) . '/vendor/autoload.php';

use FastForward\Enum\Calendar\Weekday;
use FastForward\Enum\Helper\EnumHelper;

$values = EnumHelper::values(Weekday::class);
if ($values !== [1, 2, 3, 4, 5, 6, 7]
    || EnumHelper::fromName(Weekday::class, 'Monday') !== Weekday::Monday
    || EnumHelper::tryFromName(Weekday::class, 'not-a-day') !== null
    || Weekday::tryFrom(0) !== null) {
    throw new RuntimeException('Enum lookup contract differs.');
}
try {
    EnumHelper::fromName(Weekday::class, 'not-a-day');
    throw new RuntimeException('An invalid enum name unexpectedly resolved.');
} catch (ValueError) {
}

echo "fast-forward-enum: ok\n";
