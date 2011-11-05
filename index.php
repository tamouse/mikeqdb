<?php
/**
 *
 * index - main page for mikeqdb site
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 *
 */

require_once("config.inc.php");
require_once(LIB."paginate.php");

global $quotelist;

// If there is a quote id specified on the query string, then the list
// type must be single. If not, then the list type is determined by
// examining the path info or for a 'l' parameter in the $_REQUEST
// global. 
$quote_id = get_quote_id();
if (FALSE !== $quote_id) {
  $quotelist[] = get_single_quote($quote_id);
} else {
  $quote_list_type = get_quote_list_type();
  $quotelist = get_quotes_for_page($quote_list_type,$quote_id);
}


include_once(VIEWS."showquotes.html.php");





