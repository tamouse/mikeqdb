<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * test_pilcrow
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/11/05
 * @version <2011-Oct-23 02:35>
 * @copyright (c) 2011 Tamara Temple Web Development
 * @license GPLv3
 *
 */


$pilcrow = "¶";
echo sprintf("Pilcrow: %s %d %o %x\n", $pilcrow, ord($pilcrow), ord($pilcrow), ord($pilcrow));

$chars = str_split($pilcrow);
foreach ($chars as $key => $value) {
  echo sprintf("Chars [%d]: %s %d %o %x\n", $key, $value, ord($value), ord($value), ord($value));
}


$short_pilcrow = chr(0XB6);
echo sprintf("Short Pilcrow: %s %d %o %x\n", $short_pilcrow, ord($short_pilcrow)
	     , ord($short_pilcrow), ord($short_pilcrow));


$pattern = '/['.$pilcrow.$short_pilcrow.']/';
$test_subject = 'abcde'.$pilcrow.'12345'.$short_pilcrow.'xyzzy';
echo "Test subject: $test_subject \n";
$split = preg_split($pattern, $test_subject) or die("preg_split failed");

foreach ($split as $key => $value) {
  printf("Split [%d]: %s\n",$key, $value);
}


$t0 = preg_replace($pattern,"\n",$test_subject);
$t01 = preg_replace('/\n+/',"\n",$t0);

printf("Clean test subject: %s\n",$t01) or die("first preg_replace failed: $pattern: ".preg_last_error()."\n");

$t1 = preg_replace("/[".$pilcrow."]/u","\n",$test_subject) or die("pilcrow replacement failed: ".preg_last_error()."\n");
printf("Clean test subject %s\n",$t1);
$t2 = preg_replace("/[".$short_pilcrow."]/","\n",$t1) or die("short_pilcrow replacement failed: ".preg_last_error()."\n");
printf("Cleaner test subject %s\n",$t2);
