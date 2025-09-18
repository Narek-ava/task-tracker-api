<?php

namespace App\Enums;

enum UserPosition: string
{
    case MANAGER = 'manager';
    case DEVELOPER = 'developer';
    case TESTER = 'tester';
}
