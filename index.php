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
        foreach ($days as $day => $countFiles) {
          echo "days : " . $day . " ( " . $countFiles . " images )<br/>"; 
        }
      }
    ?>
  </body>
</html>
