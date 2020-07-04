<?php
/*
	Template Library
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

// Load the template
function template($conn, $template) {
    $loader = new Twig_Loader_Filesystem('templates/' . template);
    $twig   = new Twig_Environment($loader, array(
  	'debug' => true
  ));

    $translate = new Twig_SimpleFunction('translate', function($cat, $string) {
        $lang = language;
        $ini = parse_ini_file('language/' . $lang . '/' . $lang . '.ini', TRUE);

        return $lang = $ini[$cat][$string];
    });
    $twig->addFunction($translate);

    $template = $twig->load($template . '.html');

    return $template;
}

// Load the default variables that can be used in any template
function template_vars($conn) {
    // Adding the Site Title text into the $vars
    $vars['SITE_TITLE'] = language('settings', 'SITE_TITLE');
    // Adding the Site Template into the $vars
    $vars['SITE_TEMPLATE'] = template;
    // Adding the Site Language into the $vars
    $vars['SITE_LANGUAGE'] = language;
    // Adding the Site URL into the $vars
    $vars['SITE_URL'] = url;

    return $vars;
}

// Load the error file and print an error message
function template_error($conn, $message, $file = 'error', $die = 0) {
    // Load the template
    $template = template($conn, $file);
    // Load the default template variables
    $vars = template_vars($conn);

    $vars['error_message'] = $message;

    echo $template->render($vars);
}
