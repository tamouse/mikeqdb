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
define('APP_PATH', dirname($_SERVER['SCRIPT_URL']) . DIRECTORY_SEPARATOR);

$GLOBALS['version'] = '0.1';
$GLOBALS['sitetitle'] = 'Callahans Quotes';
$GLOBALS['sitelogo'] = '';
$GLOBALS['HTMLHeader']['style'] = '<link rel="stylesheet" href="'.CSS.'style.css'.'" type="text/css" media="screen" />';
$GLOBALS['HTMLHeader']['script'] = '';
$GLOBALS['navigation'] =
  array("About" => 'about.php',
	"Top Hits" => 'tophits.php',
	"Newest" => 'newest.php',
	"Random" => 'random.php',
	"Search" => 'search.php',
	);
$GLOBALS['navsep'] = '|';


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



