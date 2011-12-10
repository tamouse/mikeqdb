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
  global $totalpages,$dbg;
  $currentpage = get_param($GLOBALS['current_page_param'],'int');
  $dbg->p("currentpage: ", (isset($currentpage)?$currentpage:"not set"),__FILE__,__LINE__,__FUNCTION__);
  if ($currentpage > $totalpages) {
    $currentpage = $totalpages;
  }
  if ($currentpage < 1) {
    $currentpage = 1;
  }
  return $currentpage;
}

/**
 * get the number of the next page in pagination sequence
 *
 * @param void
 * @return int - next page number or FALSE
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_next()
{
  if (isset($GLOBALS['currentpage'])) {
    $next = $GLOBALS['currentpage'] + 1;
    if ($next > $GLOBALS['totalpages']) return FALSE;
    return $next;
  } else {
    return FALSE;
  }
}

/**
 * get the number of the previous page in pagination sequence
 *
 * @param void
 * @return int - previous page or FALSE
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_prev()
{
  if (isset($GLOBALS['currentpage'])) {
    $prev = $GLOBALS['currentpage'] - 1;
    if ($prev < 1) return FALSE;
    return $prev;
  } else {
    return FALSE;
  }
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
  $GLOBALS['totalpages'] = ceil($GLOBALS['total_quotes'] / $GLOBALS['quotes_per_page']);
  $GLOBALS['currentpage'] = get_current_page();
  $offset = ($GLOBALS['currentpage'] - 1) * $GLOBALS['quotes_per_page'];
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
  global $qdb,$dbg;
  //$dbg->p("in get quotes partial. ",'',__FILE__,__LINE__);
  if ($offset < 0 || $offset > $GLOBALS['total_quotes']) {
    //$dbg->p("returning from offset range check.",$offset,__FILE__,__LINE__);
    $offset = 0;
  }
  if ($limit < 0 || $limit > $GLOBALS['total_quotes']) {
    //$dbg->p("returning from limit range check. ",$limit,__FILE__,__LINE__);
    $limit = $GLOBALS['total_quotes'];
  }
  
  $dbg->p("order: ",$order,__FILE__,__LINE__);

  switch ($order) {
  case 'newest':
    $orderby = 'ORDER BY created DESC, id DESC';
    break;
  case 'browse':
  case 'oldest':
    $orderby = 'ORDER BY created ASC, id ASC';
    break;
  case 'top':
  case 'tophits':
    $orderby = 'ORDER BY rating DESC, id DESC';
    break;
  case 'bottom':
  case 'bottomhits':
    $orderby = 'ORDER BY rating ASC, id ASC';
    break;
  case 'random':
    $orderby = 'ORDER BY RAND()';
    $offset = 0;
    $limit = 1;
    break;
  case 'search':
    error_page("Search is not yet implemented.");
  default:
    $dbg->p("hit default return in switch. ",$order,__FILE__,__LINE__);
    return FALSE;
    //break;
  }

  $sql = "SELECT * FROM quotes $orderby LIMIT $offset, $limit";
  $res = $qdb->query($sql);
  if (FALSE === $res) {
    error_page("Retrieval of quotes failed: (".
	       $qdb->errno.') '.$qdb->error.
	       "SQL statement: $sql");
  }
  while ($row = $res->fetch_assoc()) {
    $rows[] = $row;
  }
  return $rows;
}


