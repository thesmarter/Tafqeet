<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use thesmarter\Tafqeet\Core\Tafqeet;

try {
    echo Tafqeet::arablic(3150.9) . PHP_EOL;
    echo Tafqeet::arablic(0) . PHP_EOL;
    echo Tafqeet::arablic(1000) . PHP_EOL;
    echo Tafqeet::arablic(123456.75, 'usd') . PHP_EOL;
    echo Tafqeet::arablic('999999.99') . PHP_EOL;
} catch (\thesmarter\Tafqeet\Exception\TafqeetException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
