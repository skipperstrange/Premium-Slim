<?php

require '../../bootstrap-api.php';
require "../../vendor/autoload.php";

use Premium\Middleware\FileFilter as FileFilter;
use Premium\Middleware\ImageRemoveExif as ImageRemoveExif;
use Premium\Middleware\ListingImageFileMove as ListingImageFileMove;
use Premium\Middleware\Logging as Log;

$filter               = new FileFilter();
$removeExif           = new ImageRemoveExif();
$listingImageFileMove = new ListingImageFileMove();


$app->add(new Log());
$app->add(new \Tuupola\Middleware\JwtAuthentication($config["auth"]));



require 'routes.php';

$app->run();
