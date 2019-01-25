<?php
/*
	Template Library
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

// Load the template
function template($conn, $template) {
    $loader = new Twig_Loader_Filesystem('templates/' . default_template);
    $twig   = new Twig_Environment($loader, array(
  	'debug' => true
  ));

    $translate = new Twig_SimpleFunction('translate', function($cat, $string) {
        $lang = default_language;
        $ini = parse_ini_file('language/' . $lang . '/' . $lang . '.ini', TRUE);

        return $lang = $ini[$cat][$string];
    });
    $twig->addFunction($translate);

    $template = $twig->load($template . '.html');

    return $template;
}

// Load the default variables that can be used in any template
function template_vars($conn) {
    $vars['SITE_TITLE'] = language('settings', 'SITE_TITLE');

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
