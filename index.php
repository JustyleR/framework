<?php

/*
 * @project Justy a Framework
 * @author  JustyleR
 * @version 0.0.2
 */

// Define the file_access so we can include files
define('file_access', TRUE);

// Core files
require('config/config.php');
require('libs/Database.php');
require('libs/Bootstrap.php');
require('libs/Core.php');
require('libs/Language.php');
require('libs/Pagination.php');
require('libs/vendor/autoload.php');
require('libs/Template.php');

// Call the main functions
Bootstrap();

// Custom code
