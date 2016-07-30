<?php

require_once('browse-folder.php');
$days = getIndexByDay(__DIR__ . "/data-sample/*.jpg", 'Pacific/Chatham' );

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
          echo "<li><a href=\"view.php?date=$date\">". $dateTime->format("D j Y")."</a><em>$countFiles images</em></li>";
        }
        echo "</ul>";
      }
    ?>
  </body>
</html>
