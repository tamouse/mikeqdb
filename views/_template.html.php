<?php
/**
 *
 * _template.html - page template - used for all page views
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2011/10/10
 * Copyright (c) 2011 Tamara Temple Web Development
 *
 */
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $GLOBALS['sitetitle'];?></title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <meta name="generator" content="mikeqdb" />
   <meta name="robots" content="index,follow" />
   <?php reset($GLOBALS['HTMLHeader']);
   while (list($key,$val) = each($GLOBALS['HTMLHeader'])) {
     echo $val;
   }?>
</head>
<body>
   <div id="heading">
   <?php include_once("_heading.html.php"); ?>
   </div>

   <div id="content">
   <?php echo $content ?>
   </div>

   <div id="footing">
   <?php include_once("_footing.html.php"); ?>
   </div>

</body>
</html>
