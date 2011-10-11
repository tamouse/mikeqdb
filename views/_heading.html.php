<?php
/**
 *
 * _heading.html - page heading
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 *
 */



// left part of page heading: logo and title
echo '<div class="brand">';
if (!empty($GLOBALS['sitelogo'])) {
  echo '<img id="sitelogo" src="'.$GLOBALS['sitelogo'].'" alt="'.$GLOBALS['sitetitle'].' logo" />';
}

echo '<span id="sitetitle">'.$GLOBALS['sitetitle'].'</span>';
echo '</div>';
echo PHP_EOL;



// right part of page heading: navigation
echo '<div class="nav">';
echo '<ul>';
while (list($key,$val) = each($GLOBALS['navigation'])) {
  echo '<li><a href="'.$val.'">'.$key.' '.$GLOBALS['navsep'].' '.'</a></li>';
}
echo '</ul';
echo '</div>';
echo PHP_EOL;

