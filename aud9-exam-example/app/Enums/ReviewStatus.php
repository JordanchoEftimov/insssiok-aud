<?php

namespace App\Enums;

enum ReviewStatus: string
{
    case PENDING = 'pending';
    case DECLINED = 'declined';
    case APPROVED = 'approved';
}
