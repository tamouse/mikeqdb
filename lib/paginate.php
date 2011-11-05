<?php
/**
 *
 * paginate - enable pagination in displayed pages
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

global $qdb, $dbg;

/**
 * get the currently viewed page based on the Query parameter 'p'
 *
 * @return int - current page number
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_current_page()
{
  global $totalpages;
  if (isset($_REQUEST['p']) && is_numeric($_REQUEST['p'])) {
    $currentpage = (int) $_REQUEST['p'];
    if ($currentpage > $totalpages) {
      $currentpage = $totalpages;
    }
    if ($currentpage < 1) {
      $currentpage = 1;
    }
  } else {
    $currentpage = 1; // default to first page
  }
  return $currentpage;
}

/**
 * return an array of quotes for the current page
 *
 * @param string $order - order to select quotes: newest, oldest, tophits, bottom
 * @return array - array of quotes
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_quotes_for_page($order='newest')
{
  $totalrows = $GLOBALS['total_quotes'];
  $totalpages = ceil($totalrows / $GLOBALS['quotes_per_page']);
  $currentpage = get_current_page();
  $offset = ($currentpage - 1) * $GLOBALS['quotes_per_page'];
  $quotelist = get_quotes_partial($offset,$GLOBALS['quotes_per_page'],$order);
  return $quotelist;
}

/**
 * return an array of $limit quotes from the data base starting at $offset 
 *
 * @param int $offset - starting position
 * @param int $limit - number of quotes to pull
 * @param str $order - tag indicating what order to pull quotes in: newest, oldest, tophits, bottom
 * @return array
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_quotes_partial($offset,$limit,$order='newest')
{
  global $qdb;
  if ($offset < 0 || $offset > $GLOBALS['total_quotes']) {
    return FALSE;
  }
  if ($limit < 0 || $limit > $GLOBALS['total_quotes']) {
    return FALSE;
  }
  
  switch ($order) {
  case 'newest':
    $orderby = 'ORDER BY created DESC';
    break;
  case 'browse'
  case 'oldest':
    $orderby = 'ORDER BY created ASC';
    break;
  case 'tophits':
    $orderby = 'ORDER BY rating DESC';
    break;
  case 'bottom':
    $orderby = 'ORDER BY rating ASC';
    break;

  default:
    return FALSE;
    #break;
  }

  $sql = "SELECT * FROM quotes $orderby LIMIT $offset, $limit";
  $res = $qdb->query($sql);
  if (FALSE === $res) {
    error_page("Retrieval of quotes failed: (".
	       $qdb->errno.') '.$qdb->error,
	       "SQL statement: $sql");
  }
  while ($row = $res->fetch_array(MYSQLI_NUM)) {
    $rows[] = $row;
  }
  return $rows;
}


