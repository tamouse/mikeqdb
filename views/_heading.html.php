<?php  // -*- mode: php; time-stamp-start: "version [\"<]"; time-stamp-format: "%Y-%3b-%02d %02H:%02M"; -*- 
/**
 *
 * _heading.html - page heading
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @since 2011/10/10
 * @version <2011-Dec-12 17:49>
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
echo '<form method="get" action="'.MAIN.'/Search">';
echo '<ul>';
$navlist = array();
while (list($key,$val) = each($GLOBALS['navigation'])) {
  $navlist[] = _wrap(_link($key,$val) . $GLOBALS['navsep'],'li');
}
echo join("",$navlist);
echo _wrap('<input type="text" name="'.$GLOBALS['search_param'].'" value="" /><input type="submit" name="Search" value="Search" />','li');
echo '</ul>';
echo '</form>';
echo '</div>';
echo PHP_EOL;

echo '<div class="clearboth"></div>'.PHP_EOL;
