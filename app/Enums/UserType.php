<?php

namespace App\Enums;

enum UserType: string
{
    case CLIENT = 'client';
    case RESTAURANT = 'restaurant';
    case ADMIN = 'admin';
}
