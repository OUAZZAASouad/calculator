<?php

namespace App\Enums;
use App\Traits\EnumIterator;

enum Operation: string
{
    use EnumIterator;

    case ADDITION = '+';
    case SUBTRACTION = '-';
    case MULTIPLICATION = '*';
    case DIVISION = '/';
}
