<?php

namespace App\Enums;

enum CashTransactionType: string
{
    case SELL = 'sell';
    case REFUND = 'refund';
    case INCOME = 'income';
    case EXPENSE = 'expense';
}
