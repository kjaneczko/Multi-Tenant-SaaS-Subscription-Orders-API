<?php

namespace App\Domain\User;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case MANAGER = 'manager';
}
