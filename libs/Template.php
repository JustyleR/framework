<?php
/*
	Template Library
	The core file for the template
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

// Replace the default template codes into string
function template_replace_default($conn, $content) {

	// If there is REQUIRE tag then include the template inside the tag
	$content = template_require($conn, $content);

	// Show the content for logged or non logged users
	$content = template_check_login($content);

	// Remove the content for non admins
	$content = template_admin_show($content);

	// Easily replace strings with whatever you want from the html page
	$content = str_replace('{SITE_TITLE}', language('home', 'SITE_TITLE'), $content);
	$content = str_replace('{SITE_TEXT_TITLE}', language('home', 'SITE_TEXT_TITLE'), $content);
	$content = str_replace('{SITE_TEXT}', language('home', 'SITE_TEXT'), $content);

	// Translate the strings in the template file from the language file
	$content = template_translate($conn, $content);

	return $content;
}

// The the content of the selected file
function template($conn, $file) {
    if(file_exists('templates/'. template .'/structure/'. $file .'.html')) {

		$content = file_get_contents('templates/'. template .'/structure/'. $file .'.html');
		$content = template_replace_default($conn, $content);

		return $content;

	} else { template_error($conn, language($conn, 'errors', 'FILE_DOESNT_EXISTS') . 'templates/' . template . '/structure/' . $file, 0); }
}

// Print a error in a custom error page
function template_error($conn, $msg, $die = 0) {
    if (file_exists('templates/' . template . '/structure/error.html')) {
        if ($die == 1) {
            die($msg);
        } else {
            $content	= template($conn, 'error');
			// It will replace the strings with the ones from the language file
			$replace	= ['{ERROR_SITE_TITLE}', '{ERROR_TEXT_TITLE}', '{ERROR_TEXT}'];
			$with		= [language($conn, 'errors', 'ERROR_FILE_SITE_TITLE'), language($conn, 'errors', 'ERROR_FILE_TEXT_TITLE'), $msg];
			$content 	= str_replace($replace, $with, $content);

			echo $content;
        }
    } else {
        die(language($conn, 'errors', 'FILE_DOESNT_EXISTS') . 'templates/' . template . '/structure/error.html');
    }
}

// Function to get content between 2 comments (START - END)
function comment($comment, $scontent) {

	$start = '<!--' . $comment . '-->';
	$end = '<!--END '. $comment .'-->';
	$content = ' ' . $scontent;
    $ini = strpos($content, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($content, $end, $ini) - $ini;
    return substr($content, $ini, $len);
}

// Function to get and require template from a tag
function template_require($conn, $scontent) {

		$count = substr_count($scontent, '{TEMPLATE_REQUIRE}');
		for($i = 0; $i < $count; $i++) {
			$start = '{TEMPLATE_REQUIRE}';
			$end = '{/TEMPLATE_REQUIRE}';
			$content = ' ' . $scontent;
			$ini = strpos($content, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($content, $end, $ini) - $ini;
			$template = substr($content, $ini, $len);

			if(file_exists('templates/'. template .'/structure/'. $template .'.html')) {

				$require = file_get_contents('templates/'. template .'/structure/'. $template .'.html');
				$scontent = str_replace('{TEMPLATE_REQUIRE}'. $template .'{/TEMPLATE_REQUIRE}', $require, $scontent);

			} else { template_error($conn, language($conn, 'errors', 'FILE_DOESNT_EXISTS') . 'templates/' . template . '/structure/' . $template, 0); }
		}

		return $scontent;
}

// Function to get and translate from the html page
function template_translate($conn, $scontent) {
	$_SESSION['count2'] = substr_count($scontent, '{TRANSLATE}');
	$_SESSION['count'] = substr_count($scontent, '{TRANSLATE}');
	$test = "";

	for($i = 0; $i <= $_SESSION['count2']; $i++) {

		if($_SESSION['count'] == 0) { break; }

		$start = '{TRANSLATE}';
		$end = '{/TRANSLATE}';
		$content = ' ' . $scontent;
		$ini = strpos($content, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($content, $end, $ini) - $ini;
		$translate = substr($content, $ini, $len);

		$array = explode(',', $translate);
		$scontent = str_replace('{TRANSLATE}'. $translate .'{/TRANSLATE}', language($array[0], $array[1]), $scontent);

		$_SESSION['count'] = substr_count($scontent, '{TRANSLATE}');
	}

	return $scontent;

}

// Function to remove the content that is not supposed to be visible for logged/not logged users
function template_check_login($scontent) {

	if(isset($_SESSION['user_logged'])) {

		$count = substr_count($scontent, '<!--IF USER IS NOT LOGGED-->');

		for($i = 0; $i < $count; $i++) {

			$comment = comment('IF USER IS NOT LOGGED', $scontent);

			$scontent = preg_replace('/<!--IF USER IS NOT LOGGED-->/', '', $scontent, 1);
			$scontent = str_replace($comment, '', $scontent);
			$scontent = preg_replace('/<!--END IF USER IS NOT LOGGED-->/', '', $scontent, 1);
		}
	} else {

		$count = substr_count($scontent, '<!--END IF USER IS LOGGED-->');

		for($i = 0; $i < $count; $i++) {

			$comment = comment('IF USER IS LOGGED', $scontent);

			$scontent = preg_replace('/<!--IF USER IS LOGGED-->/', '', $scontent, 1);
			$scontent = str_replace($comment, '', $scontent);
			$scontent = preg_replace('/<!--END IF USER IS LOGGED-->/', '', $scontent, 1);
		}

	}

	return $scontent;
}

// Function to remove the content for non admins
function template_admin_show($scontent) {

	if(!isset($_SESSION['admin_logged'])) {

		$count = substr_count($scontent, '<!--IF USER IS AN ADMIN-->');

		for($i = 0; $i < $count; $i++) {

			$comment = comment('IF USER IS AN ADMIN', $scontent);

			$scontent = preg_replace('/<!--IF USER IS AN ADMIN-->/', '', $scontent, 1);
			$scontent = str_replace($comment, '', $scontent);
			$scontent = preg_replace('/<!--END IF USER IS AN ADMIN-->/', '', $scontent, 1);
		}

	}

	return $scontent;
}

// Test function to loop throuch array and replace the stuff in the template page
function template_loop($conn, $content, $loop) {
  $array = array();
  $list = '';
  foreach($loop as $id => $val) {
    $keys = array_keys($val);
    foreach($keys as $kid => $key) {
      $kkey = '[' . $key . ']';

      if (strstr($content, $kkey)) {
        $array[$id]['['. $key .']'] = $val[$key];

      }
    }
  }
  var_dump($array);
  for($i = 0; $i < count($array); $i++) {
    $keys = array_keys($array[$i]);
    $values = array_values($array[$i]);
    $comment = $content;
    

    $list		.= str_replace($keys, $values, $comment);

  }

  return $list;
}
