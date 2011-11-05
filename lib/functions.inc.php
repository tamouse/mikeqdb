<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * functions.inc - miscellaneous functions
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/10/10
 * @version <2011-Nov-05 04:29>
 * @copyright (c) 2011 Tamara Temple Web Development
 * @license GPLv3
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
 * retrieve the quote id from the query string, if it exists
 *
 * @param none
 * @return integer - quote identifier
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_quote_id()
{
  if (isset($_REQUEST[$GLOBALS['quote_id_param']]) &&
      is_numeric($_REQUEST[$GLOBALS['quote_id_param']])) {
    return (int) $_REQUEST[$GLOBALS['quote_id_param']];
  } else {
    return FALSE;
  }
}

/**
 * determine which type of quote list to retrieve
 *
 * @param 
 * @return string - type of quote list to retrieve
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_quote_list_type()
{
  // the type of quote list is determined by either the value of the
  // $_REQUEST['l'] parameter or the path info

  if (isset($_REQUEST[$GLOBALS['list_type_param']])) {
    $l = strtolower($_REQUEST[$GLOBALS['list_type_param']]);
    return (in_array($l,$GLOBALS['list_types'])) ?
      $l :
      $GLOBALS['default_list_type'];
  } else {
    $path_info = strtolower($_SERVER['PATH_INFO']);
    $paths = explode('/', $path_info);
    return (isset($paths[1]) && in_array($paths[1],$list_types)) ?
      $paths['1'] :
      $GLOBALS['default_list_type'];
  }
}

/**
 * retrieve a single quote from the data base
 *
 * @param int $id - quote id
 * @return array - record matching quote id or NULL
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function get_single_quote($id)
{
  global $qdb;
  if (!is_numeric($id)) error_page("Invalid quote identifier. Quote ID=$id");
  $sql = "call fetch_quote($id)";
  $res = $qdb->query($sql);
  if (FALSE === $res || $res->num_rows < 1) {
    error_page("Quote not found. Quote ID=$id");
  }
  $row = $res->fetch_row();
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

  $sql = 'call count_quotes()';
  $res = $qdb->query($sql);
  if (FALSE === $res || $res->num_rows < 1) {
    error_page( 'Error retrieving count of quotes: (' .
		$qdb->errno . ') ' . $qdb->error. " SQL Statement: $sql");
  }

  $row = $res->fetch_row();
  if (empty($row)) {
    error_page( 'Result set from count of quotes is empty: (' .
		$qdb->errno . ') ' . $qdb->error . "SQL Statement: $sql");
  }

  $count = $row[0];
  return $count;
}

/**
 * create an image tag given an image source and optional alt text
 *
 * @param string $src - location of image
 * @param string $alt - optional alt text for image
 * @param array $attr - optional attributes
 * @param boolean $escapetext - whether to excape html entities
 * @return string - image tag
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function _img($src,$alt=NULL,$attr=NULL, $escapetext=FALSE)
{
  global $dbg;
  $out = '<img src="' . $src . '"';
  if (!empty($alt) && is_string($alt))
    $out .= ' alt="'.
      ($escapetext)?htmlentities($alt):$alt.'"';
  if (!empty($attr) && is_array($attr)) {
    while (list($k,$v) = each($attr)) {
      $out .= " $kv=\"" .
	($escapetext)?htmlentities($v):$v.
	'"';
    }
  }
  $out .= ' />';
  return $out;
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
  if (!empty($attr) && is_array($attr)) {
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
 * @param array $attr (optional) - array containing extra tag attributes
 * @param bool $escape (optional) - whether to encode html entities or not
 * @return string - wrapped text
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function _wrap($text,$tag='p',$class=NULL,$attr=NULL,$escape=NULL)
{
  $out = '<'.$tag;
  if (!empty($class)) {
    $out .= ' class="'.$class.'"';
  }
  if (!empty($attr) && is_array($attr)) {
    while (list($k,$v) = each($attr)) {
      $out .= " $k=\"$v\"";
    }
  }
  $out .= '>';
  $out .= ($escape) ? htmlentities($text) : $text;
  $out .= "</$tag>".PHP_EOL;
  return $out;
}
