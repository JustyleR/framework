<?php

/*
	Configuration file
*/

ob_start();
session_start();
//error_reporting(2);

date_default_timezone_set('Europe/Sofia');

// MySQL Connect
define('db_host', '');
define('db_user', '');
define('db_pass', '');
define('db_name', '');

// Settings
define('url', 'http://127.0.0.1/f/'); // Don't forget to add the / at the end of the link (sitename.com/sms/)
define('default_template', 'default'); // The template that will be used
define('default_language', 'en'); // The language that will be used
