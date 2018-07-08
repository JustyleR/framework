<?php
/*
	Template Library
	The core file for the template
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

// The the content of the selected file
function template($file) {
    if(file_exists('templates/'. template .'/structure/'. $file .'.html')) {
		
		return file_get_contents('templates/'. template .'/structure/'. $file .'.html');
		
	} else { template_error(language('errors', 'FILE_DOESNT_EXISTS') . 'templates/' . template . '/structure/' . $file, 0); }
}

// Print a error in a custom error page
function template_error($msg, $die = 0) {
    if (file_exists('templates/' . template . '/structure/error.html')) {
        if ($die == 1) {
            die($msg);
        } else {
            $content	= template('error');
			$replace	= ['{ERROR_SITE_TITLE}', '{ERROR_TEXT_TITLE}', '{ERROR_TEXT}'];
			$with		= [language('errors', 'ERROR_FILE_SITE_TITLE'), language('errors', 'ERROR_FILE_TEXT_TITLE'), $msg];
			$content 	= str_replace($replace, $with, $content);
			
			echo $content;
			
        }
    } else {
        die(language('errors', 'FILE_DOESNT_EXISTS') . 'templates/' . template . '/structure/error.html');
    }
}
