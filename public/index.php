<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Kernel;

// Run the application
$kernel = new Kernel();
$kernel->run();
