<?php
/*
	Language Library
*/

if (!defined('file_access')) {
    header('Location: index');
}

// Use the language
function language($name, $string) {
    $lang = fw_language;
    if (file_exists('language/' . $lang . '/' . $lang . '.ini')) {
        $ini = parse_ini_file('language/' . $lang . '/' . $lang . '.ini', TRUE);

        return $ini[$name][$string];
    } else {
        echo "
        The Language File Doesn't Exists!<br />
        <strong>language/". $lang ."/". $lang .".ini</strong>
        ";
        die();
    }
}
