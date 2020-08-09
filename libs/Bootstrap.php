<?php
/*
	Bootstrap Library
*/

if (!defined('file_access')) {
    header('Location: index');
}

// Check the file which is in the url
function Bootstrap() {
  core();
  $status = 1;
  if(isset($_GET['p'])) {
    $page = explode('/', $_GET['p']);
    $array = array();
    if(isset($page['0'])) {
      if($page[0] == '!admin') {
        if(!isset($_SESSION['admin_logged'])) {
          core_header('home');
        }
        $fileDir = 'admin/';
      } else {
        $array[0] = '';
        $fileDir = '';
      }

      $page     = array_merge($array, $page);
      $location = 'controllers/';
      $file     = $location . $fileDir . $page[1] . '.php';

      if(file_exists($file)) {

        require_once($file);

        if(function_exists('main_info') && function_exists('main')) {
          $main_info[0] = $page[0];
          $main_info = array_merge($main_info, main_info());

          $countP     = count($page);
          $countInfo  = count($main_info);

          if($main_info[1] == $page[1] && $countP == $countInfo) {
            foreach($main_info as $key=>$main) {
              $p = $page[$key];
              switch($main) {
                case '{STRING}':
                  if(empty($p) || is_numeric($p)) { $status = 0; }
                break;

                case '{NUMBER}':
                  if(!is_numeric($p)) { $status = 0; }
                break;

                case '{EVERYTHING}':

                break;

                default:
                  if($main != $p) { $status = 0; }
                break;
              }
            }

            // RUN
            $conn = '';
            if(!empty(db_host)) { $conn = db_connect(); }
            main($conn);

          } else { $status = 0; }
        }

      } else {
        if($page[1] == 'home') {
          die(language('errors', 'FILE_DOESNT_EXISTS') . $location . $fileDir . 'home.php');
        } else { $status = 0; }
      }
    } else { $status = 0; }
  } else { $status = 0; }

  if($status == 0) {
    if(core_page()[0] == 'admin' || core_page()[0] == '!admin') {
      return core_header('!admin/home');
    }
    core_header('home');
  }
}
