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
    
	$content = template('home');
	$content = home_page($content);
	
	echo $content;
}

function home_page($content) {
	
	$replace	= ['{SITE_TITLE}', '{SITE_TEXT_TITLE}', '{SITE_TEXT}'];
	$with		= [language('home', 'SITE_TITLE'), language('home', 'SITE_TEXT_TITLE'), language('home', 'SITE_TEXT')];
	return str_replace($replace, $with, $content);
	
}