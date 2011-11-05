<?php
/**
 *
 * test_add_vote
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/11
 * Copyright (c) 2011 Tamara Temple Web Development
 *
 */

include_once("../config.inc.php");
print_r($qdb);

$res=$qdb->query('call add_vote(1,"255.255.255.255",1)');
print_r($res);

$row=$res->fetch_array(MYSQL_NUM);
print_r($row);

echo PHP_EOL.PHP_EOL;
echo "Results: ";

if ($row[0] == 'Exists') {
  echo "PASSED!";
} else {
  echo "FAILED!";
}

echo PHP_EOL.PHP_EOL;

if ($res) $res->free();
$qdb->next_result();

echo "add new vote".PHP_EOL;
$qid=1;
$ip="255.255.255.170";
$sql="call add_vote($qid,'$ip',1)";
$res=$qdb->query($sql);
if (FALSE===$res) {
  die("$sql returned error: ($qdb->errno) $qdb->error");

} else {
  echo "results of procedure call: ";
  print_r($res);
  $row = $res->fetch_array();
  echo "first row of results: ";
  print_r($row);
  echo PHP_EOL;
  if ($res) $res->free();
  $qdb->next_result();
}
echo PHP_EOL;

echo "getting vote inserted".PHP_EOL;
$sql="select * from votes where quote_id=$qid AND ip_addr='$ip'";
$res=$qdb->query($sql);
if (FALSE===$res) {
  die("$sql returned error: ($qdb->errno) $qdb->error");
} else {
  echo "query results: ";
  print_r($res);
  $row=$res->fetch_array();
  echo "row: ";
  print_r($row);
  echo PHP_EOL.PHP_EOL;
  if ($res) $res->free();
}

$sql="delete from votes where quote_id=$qid AND ip_addr = '$ip'";
$res=$qdb->query($sql);
if (FALSE===$res) {
  die("$sql returned error: ($qdb->errno) $qdb->error");
}
echo "delete results: ";
print_r($res);
if (is_object($res)) $res->free();
echo PHP_EOL;

