<?php
require '../../bootstrap-api.php';


use Premium\Middleware\FileFilter as FileFilter;
use Premium\Middleware\ImageRemoveExif as ImageRemoveExif;
use Premium\Middleware\ImageFileMove as ImageFileMove;
use Premium\Middleware\Logging as Log;

$filter               = new FileFilter();
$removeExif           = new ImageRemoveExif();
$listingImageFileMove = new ImageFileMove();


$app->add(new Log());
$app->add(new \Tuupola\Middleware\JwtAuthentication(get_config("auth")));



require 'routes.php';

$app->run();
