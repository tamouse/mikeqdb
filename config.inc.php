<?php
/**
 *
 * config.inc
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

define('APP_DIR', dirname(__FILE__));
define('ADMIN', APP_DIR . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR);
define('LIB', APP_DIR . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR);
define('VIEWS', APP_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

define('APP_PATH', dirname($_SERVER['PHP_SELF']) . DIRECTORY_SEPARATOR);
define('CSS', APP_PATH.'css'.DIRECTORY_SEPARATOR);
define('JS', APP_PATH.'js'.DIRECTORY_SEPARATOR);

include_once(LIB.'class.Debug.php');
global $dbg;
$dbg = new Debug();

// set these for development and testing
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','on');
ini_set('display_startup_errors','on');
ini_set('html_errors','on');
ini_set('docref_root','http://www.php.net/manual/en/');

$GLOBALS['version'] = '0.1';
$GLOBALS['sitetitle'] = 'Callahans Quotes';
$GLOBALS['sitelogo'] = '';
$GLOBALS['HTMLHeader']['style'] = '<link rel="stylesheet" href="'.CSS.'style.css'.'" type="text/css" media="screen" />';
$GLOBALS['HTMLHeader']['script'] = '';
$GLOBALS['listtypes'] = array('newest', 'oldest', 'tophits', 'bottomhits', 'random', 'search', 'single', 'browse');
$GLOBALS['default_list_type'] = 'newest';
// navigation should pretty well matchup with listtypes
$GLOBALS['navigation'] =
  array("About" => 'about.php',
	"Newest" => 'index.php/Newest',
	"Oldest" => 'index.php/Oldest',
	"Top Hits" => 'index.php/TopHits',
	"Bottom Hits" => 'index.php/BottomHits',
	"Browse" => 'index.php/Browse',
	"Random" => 'index.php/Random',
	"Search" => 'index.php/Search',
	);
$GLOBALS['navsep'] = ' | ';
$GLOBALS['quotes_per_page'] = 10;
$GLOBALS['linesep'] = '¶';
$GLOBALS['quote_id_param'] = 'q';
$GLOBALS['list_type_param'] = 'l';

$GLOBALS['total_quotes'] = total_quotes(); // cache total quotes so we
					   // don't have to call it a
					   // bunch of times. '

/**
 * Include functions
 */

require_once(LIB . 'functions.inc.php');

/**
 * Initialize data base
 */

require_once(ADMIN . "dbconfig.inc.php");

global $qdb;
$qdb = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
if ($qdb->connect_error) {
  error_page('Connect Error (' . $qdb->connect_errno . ') ' .
      $qdb->connect_error);
}


