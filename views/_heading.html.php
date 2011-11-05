<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * _heading.html - page heading
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/10/10
 * @version <2011-Nov-05 03:13>
 * @copyright (c) 2011 Tamara Temple Web Development
 * @license GPLv3
 *
 */


// left part of page heading: logo and title
echo '<div class="brand">';
if (!empty($GLOBALS['sitelogo'])) {
  echo '<img id="sitelogo" src="'.$GLOBALS['sitelogo'].'" alt="'.$GLOBALS['sitetitle'].' logo" />';
}
echo _wrap($GLOBALS['sitetitle'],'span',array('id'=>"sitetitle"));
echo '</div>';
echo PHP_EOL;



// right part of page heading: navigation
echo '<div class="nav">';
echo '<ul>';
$navlist = array();
while (list($key,$val) = each($GLOBALS['navigation'])) {
  $navlist[] = _wrap(_link($key,$val),'li');
}
echo join($GLOBALS['navsep'],$navlist);
echo '</ul>';
echo '</div>';
echo PHP_EOL;

echo '<div class="clearboth"></div>'.PHP_EOL;
