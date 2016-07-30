<?php

  if ( isset($_GET['date']) ) {
    $date = $_GET['date'];
  } else if( isset($argv[1]) ){
    $date = $argv[1];
  } else {
    echo "mising date argument";
    exit(1);
  }
  require_once('select-by-day.php');

  $files = getFilesByDay($date , __DIR__ . "/data-sample/*.txt", 'Pacific/Chatham');

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>day <?php echo $date; ?></title>
  </head>
  <body>
    <h1>Day : <?php echo $date; ?></h1>
    <hr/>
    <?php
      if( count($files) === 0) {
        echo "no image ti display";
      } else {
        echo "<ul>";
        foreach ($files as $filename => $filemtime) {
          $dateTime = new DateTime('@'.$filemtime);
          $dateFmt = $dateTime->format("D j Y - H:i:s");
          echo "<li><img src=\"".$filename."\"/><em>".$dateFmt."</em></li>";
        }
        echo "</ul>";
      }
     ?>
  </body>
</html>
