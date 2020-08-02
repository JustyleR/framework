<?php
/*
	Database Library
	The core file for the database
*/

if (!defined('file_access')) {
    header('Location: index');
}

// Function to connect to the database
function db_connect() {
    $conn = mysqli_connect(db_host, db_user, db_pass, db_name);

    if (!$conn && fw_debug == TRUE) {
      $message = "MySQL Connect Error! <br>" . mysqli_connect_error();
      template_error($conn, $message, 'error', 1);
    }

    mysqli_set_charset($conn, 'utf8');

    return $conn;
}

// Query function
function db_query($conn, $query) {
  $q = mysqli_query($conn, $query);
  if(mysqli_error($conn) && fw_debug == TRUE) {
    echo "<pre><code>MySQL ERROR!<br>" . mysqli_error($conn) . "</code></pre>";
  } else { return $q; }
}

// Get the number of rows
function db_num_rows($query) {
  return mysqli_num_rows($query);
}

// Return the result from the query into array
// so it can be used fast and easy into the template engine
function db_array($conn, $sql) {
  $query = db_query($conn, $sql);
  if(db_num_rows($query) > 0) {
      $array = array();
      while($row = mysqli_fetch_assoc($query)) {
          $array[] = $row;
      }
      return $array;
  } else { return FALSE; }
}

// Return only 1 row from the SQL
function db_row($conn, $sql) {
  $query = db_query($conn, $sql);
  if(db_num_rows($query) > 0) {
    return mysqli_fetch_assoc($query);
  } else { return FALSE; }
}

// Query function
function query($conn, $query) {
    return $conn = mysqli_query($conn, $query);
}

// Get the number of rows
function num_rows($query) {
    return mysqli_num_rows($query);
}