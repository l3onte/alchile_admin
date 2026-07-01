<?php

namespace App\Enums;

enum ProductMovementType: string
{
    case INPUT_PURCHASE = 'input_purchase';
    case INPUT_TRANSFER = 'input_transfer';
    case INPUT_ADJUSTMENT = 'input_adjustment';

    case OUTPUT_SALE = 'output_sale';
    case OUTPUT_WASTE = 'output_waste';
    case OUTPUT_TRANSFER = 'output_transfer';
    case OUTPUT_ADJUSTMENT = 'output_adjustment';
}
