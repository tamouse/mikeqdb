<?php
/**
 *
 * _footing.html - displayed at bottom of page
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

echo _wrap('&nbsp;','div','clearboth').PHP_EOL;

// left side of footer
echo _wrap('mikeqdb version: '.$GLOBALS['version'],'div','fleft');

// right side of footer
echo _wrap($GLOBALS['total_quotes'].' total quotes','div','fright');

echo _wrap('&nbsp;','div','clearboth').PHP_EOL;

global $dbg;

// debug messages
if ($dbg->is_on())  {
    $dbg_msgs = $dbg->getMessages();
    echo "<ul class=\"error_msg_block\" >".PHP_EOL;
    foreach ($dbg_msgs as $index => $value) {
      echo _wrap("[$index] $value","li","error_message").PHP_EOL;
    }
    echo "</ul>".PHP_EOL;
    echo _wrap(_link("Turn debug off",MAIN,array('debug' => 'false')),'p','directive').PHP_EOL
;
}

