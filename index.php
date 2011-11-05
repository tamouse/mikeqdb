<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * index - main page for mikeqdb site
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/10/10
 * @version <>
 * @copyright (c) 2011 Tamara Temple Web Development
 * @license GPLv3
 *
 */

require_once("config.inc.php");
require_once(LIB."paginate.php");

$quotelist = array();

// Snare the quote id of the query string if it exists
$quote_id = get_param($GLOBALS['quote_id_param'],'int');
$dbg->p("quote_id: ",(FALSE===$quote_id)?"FALSE":$quote_id,__FILE__,__LINE__,__FUNCTION__);

// if there is a vote case on the query string, there must be a quote
// id specified as well. 
$vote = get_param($GLOBALS['vote_param'],'string');
$dbg->p("vote: ",(FALSE===$vote)?"FALSE":$vote,__FILE__,__LINE__,__FUNCTION__);

if (FALSE !== $vote) {
  if (FALSE === $quote_id) {
    error_page ("A vote must be accompanied by a specific quote.");
  } else {
    cast_vote($quote_id,$vote);
  }
} 

$dbg->p("quote_id: ",$quote_id,__FILE__,__LINE__,__FUNCTION__);
// If there is a quote id specified on the query string, then the list
// type must be single. If not, then the list type is determined by
// examining the path info or for a 'l' parameter in the $_REQUEST
// global. 
if (FALSE !== $quote_id) {
  $quotelist[] = get_single_quote($quote_id);
} else {
  $quote_list_type = get_quote_list_type();
  $quotelist = get_quotes_for_page($quote_list_type,$quote_id);
}

$dbg->p("quotelist: ",$quotelist,__FILE__,__LINE__,__FUNCTION__);
include_once(VIEWS."showquotes.html.php");





