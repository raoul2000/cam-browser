<?php

require_once('config.php');

$folder = __DIR__ . '/' . $config['folder'] . '/' . $config['filePattern'];
$timezone = isset($config['timezone']) && ! empty($config['timezone'])
  ? $config['timezone']
  : null;

  if ( isset($_GET['date']) ) {
    $date = $_GET['date'];
  } else if( isset($argv[1]) ){
    $date = $argv[1];
  } else {
    echo "mising date argument";
    exit(1);
  }
  require_once('select-by-day.php');

  $files = getFilesByDay($date , $folder , $timezone);

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
        echo "no image to display";
      } else {
        echo "<p>".count($files)." image(s)</p>";
        echo "<ul>";
        foreach ($files as $filename => $filemtime) {
          $fileRelativePath = "data-sample/" . basename($filename);
          $dateTime = new DateTime('@'.$filemtime);
          $dateFmt = $dateTime->format("D j Y - H:i:s");
          echo "<li><img src=\"".$fileRelativePath."\" style=\"width:100%;height:auto;\"/><em>".$dateFmt."</em></li>";
        }
        echo "</ul>";
      }
     ?>
  </body>
</html>
