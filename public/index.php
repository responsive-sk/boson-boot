<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Boson\Shared\Infrastructure\Http\Kernel;

// Run the application
$kernel = new Kernel();
$kernel->run();

// NO output buffer flushing - direct output only
