<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * load_initial - do the initial load of data into the data base
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/11/05
 * @version <2011-Nov-05 17:57>
 * @copyright (c) 2011 Tamara Temple Web Development
 * @license GPLv3
 *
 */


include_once('../config.inc.php');
$dbg->on();

if ($GLOBALS['total_quotes'] > 0) {
  die("Data base is not empty, not going to overwrite.");
}

// Due to the way the quote file is stored, line breaks can either be
// in 2-byte or 1-byte characters for the pilcrow. Since we're dealing
// with them on a unix system, it makes more sense to replace these
// funky characters with a newline character as is more standard.
//
// To do this, however, requires a bit of chicanery. We have to do
// 1-byte replacement, but with a 2-byte character.
//
// First, some constants:
define('PILCROW', '¶'); // standard two-byte pilcrow character
define('SHORT_PILCROW', chr(0XB6)); // the one-byte version used in
				    // the source data some places
define('NEEDLE', '/['.PILCROW.SHORT_PILCROW.']/'); // this is what is
						   // searched for
define('REPLACEMENT', $GLOBALS['linesep']);


function fix_line_breaks($quote)
{
  $t0 = preg_replace(NEEDLE,REPLACEMENT,$quote); // convert either long or
					  // short pilcrow to a
					  // newline. 
  $t0 = preg_replace('/'.REPLACEMENT.'+/',REPLACEMENT,$t0); // squish multiple line breaks
					// down to one.
  return $t0;
}

$quote_file = APP_DIR."/db/patron_quotes.egt";
if (! file_exists($quote_file)) die ("$quote_file not found in ".APP_DIR."/db"." directory.");

$contents = file_get_contents($quote_file);
$quotes = explode("\n",  $contents);
echo _wrap("Number of quotes in file: ".count($quotes),'div').PHP_EOL;


$sql = 'call add_quote(?);';
$stmt = $qdb->prepare($sql) or
  die("SQL Statement prepare failed: (".$qdb->errno.") ".$qdb->error." SQL statement: $sql");

echo '<ol>'.PHP_EOL;
foreach ($quotes as $index => $quote) {
  if (empty($quote) or preg_match('/^\s*$/',$quote)) continue; // skip blank lines. 
  $quote = fix_line_breaks($quote);
  echo _wrap("quote [$index] is ".htmlentities($quote),'li').PHP_EOL;
  $stmt->bind_param('s',$quote) or
    die("bind_param failed: (".$stmt->errno.") ".$stmt->error." quote = $quote");
  $stmt->execute() or
    die("execute failed: (".$stmt->errno.") ".$stmt->error);
}
echo '</ol>'.PHP_EOL;

echo _wrap(total_quotes()." quotes in database.",'div').PHP_EOL;