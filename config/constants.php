<?php
/**
 *

This is was extracted from AzrtrasC.

 */

// This function must always be availible
function is_secure_connection() {
	$secure_connection = 0;
	if (isset($_SERVER['HTTPS'])) {
		$secure_connection = 1;
		if ($_SERVER["HTTPS"] == "on") {
			return $secure_connection;
		} else {
			$secure_connection = 0;
		}
		return $secure_connection;
	}
	return $secure_connection;
}

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define('DS', '/');
define('UP_ONE', '../');

define('APP', basename(dirname(dirname(__FILE__))));

if ($_SERVER['SERVER_PORT'] !== 80) {
	define('PORT', ':'.$_SERVER['SERVER_PORT']);
} else {
	define('PORT', '');
}

if (is_secure_connection() == 0):
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST']);
define('WEB_URL', 'http://'.$_SERVER['SERVER_NAME'].PORT);
 elseif (is_secure_connection() == 1):
define('BASE_URL', 'https://'.$_SERVER['HTTP_HOST']);
define('WEB_URL', 'https://'.$_SERVER['SERVER_NAME'].PORT);
endif;

define('BASE_LINK', WEB_URL);


define('JWT_SECRET', '%87y8(*U*09)(JH&8(isjkana9(&#@#5^_r#t45#$))%');