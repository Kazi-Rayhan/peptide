<?php
namespace App\Enums;

enum Level : string{
    case RETAILER = 'retailer';
    case WHOLESALER_ONE = 'wholesaler_1';
    case WHOLESALER_TWO = 'wholesaler_2';
    case DISTRIBUTOR_ONE = 'distributor_1';
    case DISTRIBUTOR_TWO = 'distributor_2';
}

