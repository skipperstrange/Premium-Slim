<?php
require '../../bootstrap-api.php';

use Premium\Middleware\Logging as Log;


$app->add(new Log());
$app->add(new \Tuupola\Middleware\JwtAuthentication(get_config("auth")));



require 'routes.php';

$app->run();
