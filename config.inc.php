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

/*********
Constants
*********/

define('APP_DIR', dirname(__FILE__));
define('ADMIN', APP_DIR . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR);
define('LIB', APP_DIR . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR);
define('VIEWS', APP_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

define('SCRIPT_NAME', $_SERVER['SCRIPT_NAME']);
define('PHP_SELF', $_SERVER['PHP_SELF']);
define('APP_PATH', dirname(SCRIPT_NAME) . DIRECTORY_SEPARATOR);
define('MAIN',APP_PATH.'index.php');
define('CSS', APP_PATH.'css'.DIRECTORY_SEPARATOR);
define('JS', APP_PATH.'js'.DIRECTORY_SEPARATOR);

include_once(LIB.'setup.Debug.php'); // include before any output

/**
 * Include common functions
 */

require_once(LIB . 'functions.inc.php');

/***********************
Configuration Variables
***********************/

$GLOBALS['version'] = '0.2';
$GLOBALS['sitetitle'] = 'Callahans Quotes <i>Beta</i>';
$GLOBALS['sitelogo'] = '';
$GLOBALS['HTMLHeader']['style'] = '<link rel="stylesheet" href="'.CSS.'style.css'.'" type="text/css" media="screen" />';
$GLOBALS['HTMLHeader']['script'] = '';
$GLOBALS['list_types'] = array('newest', 'oldest', 'tophits', 'bottomhits', 'random', 'search', 'single', 'browse');
$GLOBALS['default_list_type'] = 'newest';
// navigation should pretty well matchup with listtypes
$GLOBALS['navigation'] =
  array("About" => APP_PATH.'about.php',
	"Newest" => MAIN.'/Newest',
	"Oldest" => MAIN.'/Oldest',
	"Top Hits" => MAIN.'/TopHits',
	"Bottom Hits" => MAIN.'/BottomHits',
	"Browse" => MAIN.'/Browse',
	"Random" => MAIN.'/Random',
	);
$GLOBALS['navsep'] = ' | ';
$GLOBALS['quotes_per_page'] = 50;
$GLOBALS['linesep'] = "\n";
$GLOBALS['prev_link_text'] = '<prev';
$GLOBALS['next_link_text'] = 'next>';
$GLOBALS['vote_up_text'] = 'Thumbs Up!';
$GLOBALS['vote_down_text'] = 'Thumbs Down!';

$GLOBALS['quote_id_param'] = 'q';
$GLOBALS['list_type_param'] = 'l';
$GLOBALS['vote_param'] = 'vote';
$GLOBALS['current_page_param'] = 'p';
$GLOBALS['search_param'] = 's';

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


$GLOBALS['total_quotes'] = total_quotes(); // cache total quotes so we
					   // don't have to call it a
					   // bunch of times. '

