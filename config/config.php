<?php

/*
	Configuration file
*/

ob_start();
session_start();
error_reporting(2);

date_default_timezone_set('Europe/Sofia');

// MySQL Connect
define('db_host', '');
define('db_user', '');
define('db_pass', '');
define('db_name', '');

// Settings
define('url', ''); // Don't forget to add the / at the end of the link (sitename.com/sms/)
define('template', 'default'); // The template that will be used
define('language', 'en'); // The language that will be used
