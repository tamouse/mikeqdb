<?php
/**
 *
 * showquotes.html - display the quotes in global $quotelist
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/11
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

global $quotelist;

/**
 * format a single line of a quote
 *
 * @return string - formatted line
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function format_line($line)
{
  $line = _wrap($line,'li','quoteline',NULL, TRUE);
  // TODO: make line a little more interesting
  return $line;
}


/**
 * format the given quote
 *
 * @param array - quote record
 * @return string - formatted quote
 * @author Tamara Temple <tamara@tamaratemple.com>
 **/
function format_quote($quote)
{
  global $dbg;
  $out = array();
  $out[] = '<div class="quote" id="quote'.$quote['id'].'">';
  $out[] = _wrap(_wrap("Quote:",'span','label') .
		 _wrap(_link($quote['id'],APP_PATH.'index.php/Single',array('q'=>$quote['id'])),
		       'span','quoteid') .
		 _wrap("Rating:",'span','label') .
		 _wrap($quote['rating'],'span','rating') .
		 _wrap(_wrap("Vote:",'span','label') . 
		       _link($GLOBALS['vote_up_text'],
			     SCRIPT_NAME,
			     array('q'=>$quote['id'],'vote'=>'up'),
			     array('class'=>'voteup'))
		       . ' | ' .
		       _link($GLOBALS['vote_down_text'],
			     SCRIPT_NAME,
			     array('q'=>$quote['id'],'vote'=>'down'),
			     array('class'=>'votedown'))
		       ,
		       'span','voting'),
		 'div','quoteheading');
  $out[] = '<ul class="quotebody">';
  $lines = explode($GLOBALS['linesep'],$quote['quote_text']);
  foreach ($lines as $line) {
    $out[] = format_line($line);
  }
  $out[] = '</ul>';
  $out[] = _wrap(_wrap('Created:','span','label') .
		 _wrap($quote['created'],'span','quotedate'),
		 'div','quotedate');

  $out[] = '</div>';
  return join(PHP_EOL,$out).PHP_EOL;
}

$prev_next = '';
$prev_next .= _wrap("&nbsp;",'div','clearboth');
$prev_next .= "<div>";
if (get_prev()) $prev_next .= _wrap(_link($GLOBALS['prev_link_text'],$_SERVER['PHP_SELF'],array($GLOBALS['current_page_param'] => get_prev()),'',TRUE),'div','prev');
if (get_next()) $prev_next .= _wrap(_link($GLOBALS['next_link_text'],$_SERVER['PHP_SELF'],array($GLOBALS['current_page_param'] => get_next()),'',TRUE),'div','next');
$prev_next .= "</div>";
$prev_next .= _wrap("&nbsp;",'div','clearboth');


$content = '';
if (!$quotelist) {
  $content .= _wrap('No quotes in list','div','quotes');
} else {
  $content .= $prev_next;
  $content .= '<div class="quotes">'.PHP_EOL;
  foreach ($quotelist as $quote) {
    $content .= format_quote($quote).PHP_EOL;
  }
  $content .= '</div>'.PHP_EOL;
  $content .= $prev_next;

}

include_once(VIEWS."_template.html.php");
