<?php
/*
	Template Library
*/

if (!defined('file_access')) {
    header('Location: index');
}

// Load the template
function template($conn, $template) {
  $loader = new \Twig\Loader\FilesystemLoader('templates/' . fw_template);
  $twig   = new \Twig\Environment($loader, array(
  'debug' => fw_debug
  ));

  $translate = new \Twig\TwigFunction('translate', function($cat, $string) {
      $lang = fw_language;
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
  $vars['SITE_TEMPLATE'] = fw_template;
  // Adding the Site Language into the $vars
  $vars['SITE_LANGUAGE'] = fw_language;
  // Adding the Site URL into the $vars
  $vars['SITE_URL'] = fw_url;

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
