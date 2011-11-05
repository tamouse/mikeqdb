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
  global $dbg;
  $totalrows = $GLOBALS['total_quotes'];
  $dbg->p("totalrows: ",$totalrows,__FILE__,__LINE__);
  $totalpages = ceil($totalrows / $GLOBALS['quotes_per_page']);
  $dbg->p("totalpages: ",$totalpages,__FILE__,__LINE__);
  $currentpage = get_current_page();
  $dbg->p("currentpage: ",$currentpage,__FILE__,__LINE__);
  $offset = ($currentpage - 1) * $GLOBALS['quotes_per_page'];
  $dbg->p("offset: ",$offset,__FILE__,__LINE__);
  $dbg->p("offset numeric?",is_numeric($offset),__FILE__,__LINE__);
  $dbg->p("quotes per page: ",$GLOBALS['quotes_per_page'],__FILE__,__LINE__);
  $quotelist = get_quotes_partial($offset,$GLOBALS['quotes_per_page'],$order);
  $dbg->p("quotelist: ",$quotelist,__FILE__,__LINE__);
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
  global $qdb,$dbg;
  $dbg->p("in get quotes partial. ",'',__FILE__,__LINE__);
  if ($offset < 0 || $offset > $GLOBALS['total_quotes']) {
    $dbg->p("returning from offset range check.",$offset,__FILE__,__LINE__);
    $offset = 0;
  }
  if ($limit < 0 || $limit > $GLOBALS['total_quotes']) {
    $dbg->p("returning from limit range check. ",$limit,__FILE__,__LINE__);
    $limit = $GLOBALS['total_quotes'];
  }
  
  $dbg->p("order: ",$order,__FILE__,__LINE__);

  switch ($order) {
  case 'newest':
    $orderby = 'ORDER BY created DESC';
    break;
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
    $dbg->p("hit default return in switch. ",$order,__FILE__,__LINE__);
    return FALSE;
    #break;
  }

  $sql = "SELECT * FROM quotes $orderby LIMIT $offset, $limit";
  $dbg->p("sql statement: ",$sql,__FILE__,__LINE__);
  $res = $qdb->query($sql);
  if (FALSE === $res) {
    error_page("Retrieval of quotes failed: (".
	       $qdb->errno.') '.$qdb->error,
	       "SQL statement: $sql");
  }
  $dbg->p("results from query: ",$res,__FILE__,__LINE__);
  while ($row = $res->fetch_assoc()) {
    $rows[] = $row;
  }
  $dbg->p("Rows returned: ",$rows,__FILE__,__LINE__);
  return $rows;
}


