<?php
echo '<pre>';

/**
 * Perform file purge.
 *
 * The selection of files to purge is based on the following conditions :
 * - file must match $pattern
 * - last modification date must not be greate than the corresponding retention days
 * valute which is configured.
 *
 * @param  string $pattern     the search file pattern
 * @param  array $configPurge  the configuration array
 * @param  DateTime $dateNow   used as reference date for delay calculation
 * @return boolean             TRUE in cs of success, FALSE otherwise
 */
function purgeFiles($pattern, $configPurge, $dateNow)
{
  echo "procesing $pattern\n";

  // list files by last modification date ////////////////////////////////////////
  //
  $files = glob($pattern) ;
  if( count($files) == 0) {
    // no file : exit
    echo "no file found\n";
    return false;
  }

  // Extract files to purge //////////////////////////////////////////////////////
  //
  foreach ($files as $file) {
    $dateMTime = new DateTime("@".filemtime($file));

    $dateDiff = date_diff($dateNow, $dateMTime);
    echo "$file : $dateDiff->days day(s) : ";

    if( $dateDiff->days >= $configPurge['imageRetentionDays']) {
      echo "selected\n";
      $filesToDelete[] = $file;
    } else {
      echo "skipped\n";
    }
  }

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
  return true;
}

// main ////////////////////////////////////////////////////////////////////////
//
$dateNow = new DateTime();
echo "starting purge : ".$dateNow->format('Y-m-d H:i:s')."\n\n";

require("config.php");
$configPurge = $config['service-purge'];

// Validate coniguration ///////////////////////////////////////////////////////
//

if( array_key_exists('imageRetentionDays', $configPurge)
    && ! is_integer($configPurge['imageRetentionDays'])) {
   echo "ERROR : imageRetentionDays must be an integer";
   exit(1);
 } elseif ( $configPurge['imageRetentionDays'] <= 0) {
   echo "ERROR : imageRetentionDays must be greater than 0";
   exit(1);
 }

if( array_key_exists('videoRetentionDays', $configPurge)
    && ! is_integer($configPurge['videoRetentionDays'])) {
   echo "ERROR : videoRetentionDays must be an integer";
   exit(1);
 } elseif ( $configPurge['videoRetentionDays'] <= 0) {
   echo "ERROR : videoRetentionDays must be greater than 0";
   exit(1);
 }

// purge image and video files /////////////////////////////////////////////////
//
$dirSnapshot = $config['baseFolder'] . '/' . $config['folderImg']   . '/' . $config['imageFilePattern'];
$dirVideo    = $config['baseFolder'] . '/' . $config['folderVideo'] . '/' . $config['videoFilePattern'];

purgeFiles($dirSnapshot, $configPurge, $dateNow);
purgeFiles($dirVideo,    $configPurge, $dateNow);

echo '</pre>';
