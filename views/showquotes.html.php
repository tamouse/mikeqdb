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
  $line = _wrap($line,'li','quoteline',TRUE);
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
  $out = array();
  $out[] = '<div class="quote" id="quote'.$quote['id'].'">';
  $out[] = _wrap(_wrap("Quote:",'span','label') .
		 _wrap(_link($quote['id'],APP_PATH.'single.php',array('q'=>$quote['id'])),
		       'span','quoteid') .
		 _wrap("Rating:",'span','label') .
		 _wrap($quote['rating'],'span','rating') .
		 _wrap(_wrap("Vote:",'span','label') . 
		       _link(_img(CSS.'thumbsup.gif','thumbs up').' Thumbs Up',APP_PATH.'castvote.php',array('q'=>$quote['id'],'vote'=>'up'))
		       . ' | ' .
		       _link(_img(CSS.'thumbsdown.gif','thumbs down').' Thumbs Down',APP_PATH.'castvote.php',array('q'=>$quote['id'],'vote'=>'down'))
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


if (!$quotelist) {
  $content = _wrap('No quotes in list','div','quotes');
} else {
  $content = '<div class="quotes">'.PHP_EOL;
  if (is_array($quotelist)) {
    foreach ($quotelist as $quote) {
      $content .= format_quote($quote).PHP_EOL;
    }
  } else {
    $content .= format_quote($quote).PHP_EOL;
  }
  $content .= '</div>'.PHP_EOL;
}

include_once(VIEWS."_template.html.php");
