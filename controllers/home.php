<?php

/*
	Home page
*/

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main($conn) {
    // Load the template
    $template = template($conn, 'index');
    // Load the default template variables
    $vars = template_vars($conn);

    /*
    * You can do something like
    * $vars['message'] = 'Message']
    * And print it in the template file like this:
    * {{ message }}
    */

    // Render the template
    echo $template->render($vars);
}
