<?php

function getFilesByDay($day, $pattern, $timezone = null)
{
  $result = [];
  $files = glob($pattern, GLOB_NOSORT);
  if( $files !== FALSE ) {
    foreach($files as $file) {
      $date=new DateTime('@'.filemtime($file));
      if($timezone != null){
        $date->setTimezone(new DateTimeZone($timezone));
      }
      if ( $day === $date->format('Ymd')){
        $result[$file] = $date->format('H:i:s');
      }
    }
  }
  return $result;
}


$result = getFilesByDay("20160729", __DIR__ . "/data-sample/*.jpg", 'Europe/Paris' );
print_r($result);
