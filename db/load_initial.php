<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * load_initial - do the initial load of data into the data base
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/11/05
 * @version <2011-Nov-05 12:38>
 * @copyright (c) 2011 Tamara Temple Web Development
 * @license GPLv3
 *
 */


require_once("../config.inc.php");
$dbg->on();

if ($GLOBALS['total_quotes'] > 0) {
  die("Data base is not empty, not going to overwrite.");
}

$quote_file = APP_ROOT."db/patron_quotes.egt";
if (! file_exists($quote_file)) die ("$quote_file not found in ".APP_ROOT."db"." directory.");

$contents = file_get_contents($quote_file);
$quotes = explode("\n",  $contents);
$dbg->p("quotes:",$quotes,__FILE__,__LINE__,__FUNCTION__);
echo _wrap("Number of quotes in file: ".count($quotes),'div').PHP_EOL;


$sql = 'call add_quote(?);';
$stmt = $qdb->prepare($sql) or
  die("SQL Statement prepare failed: (".$qdb->errno.") ".$qdb->error." SQL statement: $sql");

echo '<ul>'.PHP_EOL;
foreach ($quotes as $index => $quote) {
  echo _wrap("quote is ".htmlentities($quote),'li').PHP_EOL;
  $stmt->bind_param('s',$quote) or
    die("bind_param failed: (".$stmt->errno.") ".$stmt->error." quote = $quote");
  $stmt->execute() or
    die("execute failed: (".$stmt->errno.") ".$stmt->error);
}
echo '</ul>'.PHP_EOL;

echo _wrap(total_quotes()." quotes in database.",'div').PHP_EOL;