<?php

/**
 *
Custom functions

This is was extracted from AzrtrasC.

@author <skipperstrange@gmail.com>

 */

function generateRandom($name = null) {
	return sha1(md5($name.time()));
}

function mapObjectValues($object, $array) {
	foreach ($array as $key => $value) {
		$object->$key = $value;
	}
}

function encryptValue($input) {
	return sha1(md5($input));
}

function str_namespace( Array $array){
	return $string = implode('\\',$array);
}

function str_api_namespace(String $version)
{
	return str_namespace([APP_NAME, ucfirst(API_FOLDER), $version]);
}

function str_api_controller_namespace()
{
	return str_namespace([APP_NAME, ucfirst(API_FOLDER), ucfirst(API_CONTROLLERS_FOLDER)]);
}