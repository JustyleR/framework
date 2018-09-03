<?php

/*
	Home page
*/

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main($conn) {
    
	$content = template($conn, 'home');
	
	echo $content;
}
