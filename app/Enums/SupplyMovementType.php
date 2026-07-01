<?php

namespace App\Enums;

enum SupplyMovementType: string
{
    case INPUT_PURCHASE = 'input_purchase';
    case INPUT_TRANSFER = 'input_transfer';
    case INPUT_ADJUSTMENT = 'input_adjustment';

    case OUTPUT_CONSUMPTION = 'output_consumption';
    case OUTPUT_WASTE = 'output_waste';
    case OUTPUT_TRANSFER = 'output_transfer';
    case OUTPUT_ADJUSTMENT = 'output_adjustment';
}
