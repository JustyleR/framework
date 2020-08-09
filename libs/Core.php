<?php
/*
	Core Library
	The core functions for the system
*/

if (!defined('file_access')) {
    header('Location: index');
}

// The core function
function core() {
  ob_start();
  session_start();
  define('fw_url', core_getURL());

  if(fw_debug != TRUE) {
    error_reporting(0);
  }
}

// Get the url
function core_getURL() {
  if(isset($_SERVER['HTTPS'])){
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  }
  else{
      $protocol = 'http';
  }

  return $protocol . "://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']);
}

// Function to get the url into array
function core_page() {
    if (isset($_GET['p'])) {
        $page = $_GET['p'];
        $page = explode('/', $page);

        return $page;
    }
}

// Return pages in a string
function core_page_string($page) {
  $countP = count($page) - 1;
  $string = '';
  for($i = 1; $i <= $countP; $i++) {
    $backslash = '';
    if($i < $countP) {
      $backslash = '/';
    }
    $string .= $page[$i] . $backslash;
  }
  return $string;
}

// Function to redirect to a page
function core_header($location, $time = 0) {
  if(empty($location)) {
    $pages = core_page();
    $thePage = '';
    foreach($pages as $id=>$page) {
      if($id == 0) {
        $thePage .= $page;
      } else {
        $thePage .= '' . $page;
      }
    }
    $location = fw_url . $thePage;
  } else { $location = fw_url . '/' . $location; }

    if ($time == 0) {
        header('Location: ' . $location);
    } else {
        header('refresh:' . $time . '; url=' . $location);
    }
}

// Set a message in session so it will be able to be printed in another page
function core_message_set($session, $msg) {
    $_SESSION['msg_' . $session] = $msg . '<>' . strtotime('now');
}

// Print the message and call a function to delete the session which has the message
function core_message($msg) {
    if (isset($_SESSION['msg_' . $msg])) {
        $session = explode('<>', $_SESSION['msg_' . $msg]);
        if ($session[1] <= strtotime('now')) {
            unset($_SESSION['msg_' . $msg]);
        }

        return $session[0];
    }
}

// Get the date
// ($get: all - default[d-m-Y H:i] else use custom) , ($plus: + 1 month, 1 day, 1 hour, 50 seconds and etc)
function core_date($get = 'all', $plus = 0) {
    switch($get) {
      case 'all':
        if($plus) {
          $date = date('d-m-Y H:i', strtotime($plus));
        } else { $date = date('d-m-Y H:i'); }
      break;

      default:
        if($plus) {
          $date = date($get, strtotime($plus));
        } else { $date = date($get); }
      break;
    }

    return $date;
}

// Check a session and redirects him
// ($session: the session name) , ($status: 0/1 check if the session is set or not)
function core_check_session($session, $status) {
    if ($status == 1) {
        if (!isset($_SESSION[$session])) {
            core_header('home');
        }
    } else {
        if (isset($_SESSION[$session])) {
            core_header('home');
        }
    }
}

// A function that checks a string for and protects it (mostly for SQL)
function core_POSTP($conn, $string) {
    $string = mysqli_real_escape_string($conn, $string);

    return $string;
}

// Generate a random string
// ($length: what will be the length) , ($upper: Uppercase 0/1)
function core_random_string($lenght, $upper = 0) {
    $array = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m',1,2,3,4,5,6,7,8,9,0);

    $string = '';

    for ($i = 0; $i < $lenght; $i++) {
        $string = $string . $array[rand(0, count($array) - 1)];
    }

    if ($upper == 1) {
        return strtoupper($string);
    } else {
        return $string;
    }
}

// Check if any vars in array is empty
function core_empty($array) {
  $status = 1;
  foreach($array as $row) {
    if(empty($row)) {
      $status = 0;
      break;
    }
  }
  return $status;
}
