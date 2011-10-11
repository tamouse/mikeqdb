<?php
/**
 *
 * error_page - display an error page to the user
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

global $error_msg;

$content = '
<h1>Ooops!</h1>
<h3>There was an error.</h3>
';

if (is_array($error_msg)) {
  while (list($key,$val) = each($error_msg)) {
    $content .= _wrap($val,'p','error');
  }
} else {
  $content .= _wrap($error_msg,'p','error');
}


include_once("_template.html.php");
