<?php
/*
	Pagination Library
*/

if (!defined('file_access')) {
    header('Location: index');
}

// Pagination function
  // $conn => SQL Connection
  // $sql => SQL Query
  // $limit => Limit for results per page
  // $pages => How much pages to show on the pagination links
// It will return an array with 2 values (0 => pagination , 1 => sql results)
function pagination($conn, $sql, $limit = 5, $p_pages = 5) {
    $query = query($conn, $sql);
    if (num_rows($query) > 0) {
        $array = array();
        $page  = array('page' => '', 'link' => '');

        foreach (core_page() as $id => $p) {
            if ($p === 'cPage') {
                $page['page'] = $id + 1;
            }
            $page['link'] .= $p;

            if (count(core_page()) - 1 != $id) {
                $page['link'] .= '/';
            }
        }

        $npage = explode('/', $page['link']);
        $cpage = $npage[$page['page']];


        if ($cpage == 0) {
            $npage[$page['page']] = 1;
            core_header(printPage($npage));
        }

        $result = ceil(num_rows($query) / $limit);

        if ($cpage > $result) {
            $npage[$page['page']] = 1;
            core_header(printPage($npage));
        }

        $startResult = $cpage * $limit - $limit;

        $query = query($conn, $sql . " LIMIT $startResult,$limit");

        while ($row = fetch_assoc($query)) {
            $array[] = $row;
        }
        $prevPage = $cpage - 1;
        $nextPage = $cpage + 1;
        if ($prevPage == 0) {
            $prevPage = 1;
        }

        if ($nextPage > $result) {
            $nextPage = $result;
        }

        $prevPages = [];
        $nextPages = [];
        for($i = max(1, $cpage - $p_pages); $i <= min($cpage + $p_pages, $result); $i++) {
          if($i < $cpage) {
            $prevPages[] = $i;
          } else if($i > $cpage) {
            $nextPages[] = $i;
          }
        }

        $pagination = array('prev' => $prevPage, 'next' => $nextPage, 'max' => $result, 'prevPages' => $prevPages, 'nextPages' => $nextPages, 'cPage' => $cpage);

        return array($pagination, $array);
    } else {
        return '';
    }
}

// Redirect to the same page with a valid url
function printPage($array) {
    $string = '';

    foreach ($array as $id => $page) {
        $string .= $page;

        if (count($array) - 1 != $id) {
            $string .= '/';
        }
    }

    return $string;
}
