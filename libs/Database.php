<?php
/*
	Database Library
	The core file for the database
*/

if (!defined('file_access')) {
    header('Location: home');
}

// Function to connect to the database
function connect() {
    $conn = mysqli_connect(db_host, db_user, db_pass, db_name);

    if (!$conn) {
        template_error($conn, 'Cant connect to MySQL!', 1);
    }

    mysqli_set_charset($conn, 'utf8');

    return $conn;
}

// Query function
function query($conn, $query) {
    return $conn = mysqli_query($conn, $query);
}

// Get the number of rows
function num_rows($query) {
    if (mysqli_num_rows($query) > 0) {
        $return = mysqli_num_rows($query);
    } else {
        $return = 0;
    }

    return $return;
}

// Fetch assoc
function fetch_assoc($query) {
    return mysqli_fetch_assoc($query);
}

// Fetch array
function fetch_array($query) {
    return mysqli_fetch_array($query);
}

// Return the result from the query into array
// so it can be used fast and easy into the template engine
function db_array($conn, $sql) {
    $query = query($conn, $sql);
    if (num_rows($query) > 0) {
        $array = array();
        while ($row = fetch_assoc($query)) {
            $array[] = $row;
        }

        return $array;
    } else {
        return '';
    }
}
