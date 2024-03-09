<?php

declare(strict_types=1);

namespace App\Shared\Nsign\Domain;

enum UserType: string
{
    case unregistered = 'unregistered';
    case registered = 'registered';
    case moderator = 'moderator';
    case teamAdmin = 'team_admin';
    case doesNotExist = 'does_not_exist';
}