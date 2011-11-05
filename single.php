<?php
/**
 *
 * single - show a single quote
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/11
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

require_once("config.inc.php");

global $quotelist,$dbg;
$quotelist = array();

if (isset($_REQUEST['q']) && is_numeric($_REQUEST['q'])) {
  $qid = (int) $_REQUEST['q'];
  $quote = fetch_quote($qid);
  $quotelist[] = $quote;
} else {  
}

include_once(VIEWS."showquotes.html.php");

/**
 * fetch a single quote
 *
 * @return array - quote record
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function fetch_quote($qid)
{
  global $qdb, $dbg;
  $sql = "call fetch_quote($qid)";
  $res = $qdb->query($sql);
  $row = $res->fetch_assoc();
  return $row;
}