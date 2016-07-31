<?php

require_once('lib/browse-folder.php');
require_once('config.php');

$folder = __DIR__ . '/' . $config['folder'] . '/' . $config['filePattern'];
$timezone = isset($config['timezone']) && ! empty($config['timezone'])
  ? $config['timezone']
  : null;

$days = getIndexByDay($folder, $timezone );

 ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>images</title>
  </head>
  <body>
    <h1>Days</h1>
    <hr/>
    <?php
      if( count($days) == 0 ) {
        echo "no image found";
      } else {
        echo "<ul>";
        foreach ($days as $date => $countFiles) {
          $year  = substr($date,0,4);
          $month = substr($date,4,2);
          $day   = substr($date,6,2); //day number
          $dateTime = new DateTime("$year/$month/$day");
          echo "<li><a href=\"view.php?date=$date\">". $dateTime->format("D j Y")."</a> <em>$countFiles image(s)</em></li>";
        }
        echo "</ul>";
      }
    ?>
  </body>
</html>
