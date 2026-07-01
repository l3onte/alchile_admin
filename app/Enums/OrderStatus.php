<?php

namespace App\Enums;

enum OrderStatus : string
{
    case COMPLETED = 'completed';
    case PENDING = 'pending';
    case IN_PREPARATION = 'in_preparation';
    case READY = 'ready';
    case DELIVERED = 'delivered';
    case CANCELED = 'canceled';
}
