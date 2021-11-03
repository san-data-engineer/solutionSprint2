<?php declare(strict_types=1);

use Illuminate\Foundation\Application;
use Bref\LaravelBridge\Queue\LaravelSqsHandler;

require __DIR__ . '/vendor/autoload.php';

/**
 * @var Application $app
 */
$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

return $app->make(LaravelSqsHandler::class, [
  'connection' => 'sqs',
  'queue'      => getenv('AWS_SQS_PREFIX') . '/' . getenv('AWS_SQS_QUEUE'),
]);
