<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * setup.Debug - set up debugging stuff for this app
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/11/05
 * @version <2011-Oct-23 02:35>
 * @copyright (c) 2011 Tamara Temple Web Development
 * @license GPLv3
 *
 */

include_once(LIB.'class.Debug.php');

global $dbg;
$dbg = new Debug(FALSE);

if (isset($_REQUEST['debug'])) {
  switch (strtolower($_REQUEST['debug'])) {
  case 'true':
    turn_on_debugging();
    break;
    
  default:
    turn_off_debugging();
    break;
  }
} else {
  if ($_COOKIE['MIKEQDB_DEBUG'] == 'TRUE')    {
    turn_on_debugging();
  }
  else {
    turn_off_debugging();
  }
}

function turn_on_debugging()
{
  global $dbg;
  $dbg->on();
  $dbg->hold(TRUE);
  setcookie('MIKEQDB_DEBUG', 'TRUE', time()+3600, APP_PATH );
}

function turn_off_debugging()
{
  global $dbg;
  $dbg->off();
  $dbg->hold(FALSE);
  setcookie('MIKEQDB_DEBUG', 'FALSE', 0, APP_PATH );
}