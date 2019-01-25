<?php
/*
	Language Library
*/

if (!defined('file_access')) {
    header('Location: home');
}

// Use the language
function language($name, $string) {
    $lang = default_language;
    if (file_exists('language/' . $lang . '/' . $lang . '.ini')) {
        $ini = parse_ini_file('language/' . $lang . '/' . $lang . '.ini', TRUE);

        return $ini[$name][$string];
    } else {
        template_error($conn, 'The language file doesn\'t exists!<br />
	<strong>language/' . $lang . '/' . $lang . '.ini</strong>', 1);
    }
}
