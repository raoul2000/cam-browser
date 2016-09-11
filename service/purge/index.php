<?php
$dateNow = new DateTime();
echo "starting purge : ".$dateNow->format('Y-m-d H:i:s')."\n\n";

require("config.php");
$configPurge = $config['service-purge'];

// Validate coniguration ///////////////////////////////////////////////////////
//
if( array_key_exists($configPurge,'imageRetentionDays')
    && ! is_integer($configPurge['imageRetentionDays'])) {
   echo "ERROR : imageRetentionDays must be an integer";
   exit(1);
 }


// list files by last modification date ////////////////////////////////////////
//
$dirSnapshot = $config['baseFolder'] . '/' . $config['folderImg'] . '/' . $config['imageFilePattern'];

echo "procesing $dirSnapshot\n";

$files = glob($dirSnapshot) ;
if( count($files) == 0) {
  // no file : exit
  echo "no file found\n";
  exit(0);
}

// Extract files to purge //////////////////////////////////////////////////////
//
$filesToDelete = array_map(function($file) use($configPurge, $dateNow){
  $dateMTime = new DateTime("@".filemtime($file));

  $dateDiff = date_diff($dateNow, $dateMTime);
  echo "$file : $dateDiff->days day(s) : ";

  if( $dateDiff->days >= $configPurge['imageRetentionDays']) {
    echo "selected\n";
    return $file;
  } else {
    echo "skipped\n";
  }

},$files);

//var_dump($filesToDelete);

echo "files selected for deletion : ".count($filesToDelete). "\n";

// delete selected files ///////////////////////////////////////////////////////
//
if( isset($configPurge['simulationMode']) && $configPurge['simulationMode'] === false) {
  foreach ($filesToDelete as $file) {
    $result = @unlink($file);
    echo "file : $file - deleted : " . ($result === true ? 'SUCCESS' : 'FAILURE'). "\n";
  }
} else {
  echo "simulation mode : ON\nNo file deleted\n";
}
exit(0);
