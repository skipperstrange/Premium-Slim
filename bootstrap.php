<?php
require "includes.php";
$env = get_config('env');

//if(($env['displayErrorDetails'] == true) || ($env['mode'] == 'development')){
    ini_set('display_errors',1);
//}

require "./vendor/autoload.php";
