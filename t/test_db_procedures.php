<?php
/**
 *
 * test_db_procedures
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/11
 * Copyright (c) 2011 Tamara Temple Web Development
 * License: GPLv3
 *
 */

include_once("../config.inc.php");

global $qdb, $dbg;
$dbg->nohtml(TRUE);

echo "Testing fetch_quote".PHP_EOL;

$sql='call fetch_quote(1)';
$res=$qdb->query($sql);
if (FALSE===$res) {
  die("$sql returned error: ($qdb->errno) $qdb->error");
} else {
  $row=$res->fetch_assoc();
  if ($row['id'] == 1) {
    $Results="Passed";
  } else {
    $Results="Failed";
  }
}
$res->free();
$qdb->next_result();

echo "Results: $Results".PHP_EOL;


echo PHP_EOL."Testing count_quotes".PHP_EOL;
$sql="call count_quotes();";
$res=$qdb->query($sql);
//$dbg->p("results from query: ",$res,__FILE__,__LINE__);
if (FALSE===$res) {
  die("$sql returned error: ($qdb->errno) $qdb->error");
} else {
  $row=$res->fetch_array();
  //$dbg->p("results from fetch_array",$row,__FILE__,__LINE__);
  if ($row) {
    print_r($row);
    $Results="Passed";
  } else {
    $Results="Failed";
  }
  $res->free();
  $qdb->next_result();
}

echo "Results: $Results".PHP_EOL;
echo PHP_EOL.PHP_EOL;

echo "testing procedure check_ip".PHP_EOL;
$ip="255.255.255.255";
$qid=1;
$sql="call check_ip($qid,'$ip')";
$res=$qdb->query($sql);
if (FALSE===$res) {
  die("$sql returned error: ($qdb->errno) $qdb->error");
}
echo "check_ip result: ";
print_r($res);

if ($res->num_rows > 0) {
  $row=$res->fetch_array();
  echo "Row returned: ";
  print_r($row);
  echo PHP_EOL;
  $res->free();
  $qdb->next_result();
}

echo PHP_EOL.PHP_EOL;

echo "testing function ip_p\n";
$ip="255.255.255.255";
$qid=1;
$sql="select ip_p($qid,'$ip')";
$res=$qdb->query($sql);
if (FALSE===$res) die("$sql returned error: ($qdb->errno) $qdb->error");

echo "ip_p results: ";
print_r($res);

if ($res->num_rows > 0) {
  $row=$res->fetch_array();
  echo "First row of results: ";
  print_r($row);
  $res->free();
}

echo "\n\n";
