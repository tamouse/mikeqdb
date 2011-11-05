<?php
/**
 *
 * newest - show the newest quotes in the file
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

require_once("config.inc.php");
require_once(LIB."paginate.php");

global $quotelist, $dbg;
$quotelist = get_quotes_for_page('newest');

$dbg->p("Size of quotelist",count($quotelist),__FILE__,__LINE__);

include_once(VIEWS."showquotes.html.php");


