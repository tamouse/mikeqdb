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
 * explode a string with escaped explode delimiters
 * from: http://php.net/manual/en/function.explode.php
 *
 * @param string $delimiter - used to explode string
 * @param string $string - string to explode
 * @return void
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function explode_escaped( $delimiter, $string ) {
    $string = str_replace( '\\' . $delimiter, urlencode( $delimiter ), $string );
    return array_map( 'urldecode', explode( $delimiter, $string ) );
}

/**
 * explode a string with quoted elements
 * from http://stackoverflow.com/questions/2202435/php-explode-the-string-but-treat-words-in-quotes-as-a-single-word
 *
 * @param string $string - string to explode
 * @return array - exploded string
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function explode_quoted($string)
{
  preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $string, $matches);
  return $matches[0];
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
 * wrap a link around some text
 *
 * @param string $text - subject of link
 * @param string $href - the link target
 * @param array $query - query string to append to link target
 * @param array $attr - other link tag attributes
 * @param boolean $escapetext - flag to indicate inner text should be escaped
 * @return string - link html
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function _link($text, $href, $query=NULL, $attr=NULL, $escapetext=FALSE)
{
  $out = '<a href="' . $href;
  if (!empty($query) && is_array($query)) {
    $out .= '?' . http_build_query($query);
  }
  $out .='"';
  if (!emptry($attr) && is_array($attr)) {
    while (list($k,$v) = each($attr)) {
      $out .= " $k=\"$v\"";
    }
  }
  $out .= '>';
  $out .= ($escapetext) ? htmlentities($text) : $text;
  $out .= '</a>';
  return $out;
}

/**
 * wrap text inside an html tag, optionally including a class
 *
 * @param string $text - the text to be wrapped (will be passed through htmlentities)
 * @param string $tag (optional) - tag to use to wrap text. defaults to 'p'
 * @param string $class (optional) - class to use in wrapping item. defaults to none
 * @param bool $escape (optional) - whether to encode html entities or not
 * @return string - wrapped text
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function _wrap($text,$tag='p',$class=NULL,$escape=NULL)
{
  $out = '<'.$tag;
  if (!empty($class)) {
    $out .= ' class="'.$class.'"';
  }
  $out .= '>';
  $out .= ($escape) ? htmlentities($text) : $text;
  $out .= "<$tag>".PHP_EOL;
  return $out;
}
