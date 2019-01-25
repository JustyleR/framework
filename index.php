<?php

/*
 * @project Minecraft Shop
 * @author  JustyleR
 * @version 0.0.1
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
require('libs/Users.php');

// Call the main functions
Bootstrap();

// Custom code
