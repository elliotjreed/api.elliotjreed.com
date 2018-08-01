<?php
declare(strict_types=1);

use ElliotJReed\App;

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/../config/settings.php';

$app = (new App($settings))->get();
$app->run();
