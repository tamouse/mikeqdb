<?php
/**
 *
 * functions.inc - miscellaneous functions
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */


/**
 * prepare and emit an error page
 *
 * @return void
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function error_page($errormsgs='')
{
  global $error_msg;
  if (empty($errormsgs)) {
    $error_msg = 'No error message given.';
  } else {
    $error_msg = $errormsgs;
  }
  include_once(VIEWS."error_page.php");
  exit;
}




/**
 * return the total number of quotes in the data base
 *
 * @return int/string - returns number of quotes, or error message
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function total_quotes()
{
  global $qdb;

  $sql = 'SELECT COUNT(`id`) FROM `quotes`';
  $res = $qdb->query($sql);
  if (FALSE === $res || $res->num_rows < 1) {
    return 'Error retrieving count of quotes: (' .
      $qdb->errno . ') ' . $qdb->error. " SQL Statement: $sql";
  }

  $row = $res->fetch_row();
  if (empty($row)) {
    return 'Result set from count of quotes is empty: (' .
      $qdb->errno . ') ' . $qdb->error . "SQL Statement: $sql";
  }

  $count = $row[0];
  return $count;
}

/**
 * wrap text inside an html tag, optionally including a class
 *
 * @param string $text - the text to be wrapped (will be passed through htmlentities)
 * @param string $tag (optional) - tag to use to wrap text. defaults to 'p'
 * @param string $class (optional) - class to use in wrapping item. defaults to none
 * @return string - wrapped text
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function _wrap($text,$tag='p',$class=nil)
{
  $out = '<'.$tag;
  if (!empty($class)) {
    $out .= ' class="'.$class.'"';
  }
  $out .= '>';
  $out .= htmlentities($text);
  $out .= "<$tag>".PHP_EOL;
  return $out;
}
