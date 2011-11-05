<?php
/**
 *
 * oldest - show oldest quotes first
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/11
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */


require_once("config.inc.php");
require_once(LIB."paginate.php");

global $quotelist, $dbg;
$quotelist = get_quotes_for_page('oldest');

//$dbg->p("Size of quotelist",count($quotelist),__FILE__,__LINE__);

include_once(VIEWS."showquotes.html.php");




