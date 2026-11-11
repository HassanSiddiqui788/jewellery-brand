<?php

declare(strict_types=1);

use Core\Application;
use Core\Http\Request;

/** @var Application $app */
$app = require dirname(__DIR__) . '/bootstrap/app.php';

$request = Request::capture();
$response = $app->handleHttp($request);
$response->send();

