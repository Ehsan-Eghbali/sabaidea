<?php

namespace bootstrap;

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
//$DB = require __DIR__.'/../config/DB.php';

$app = AppFactory::create();
// If you are adding the pre-packaged ErrorMiddleware set `displayErrorDetails` to `false`
$app->addErrorMiddleware(true, true, true);

$route = require __DIR__.'/../routes/web.php';
$route($app);
$app->run();