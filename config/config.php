<?php

/*
	Configuration file
*/

ob_start();
session_start();

date_default_timezone_set('Europe/Sofia');

// MySQL Connect
define('db_host', 'localhost');
define('db_user', 'root');
define('db_pass', '');
define('db_name', 'sms');

// Settings
define('url', 'http://127.0.0.1/framework/'); // Don't forget to add the / at the end of the link (sitename.com/sms/)
define('template', 'default'); // The template that will be used
define('default_language', 'en'); // The language that will be used