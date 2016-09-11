<?php
$dateNow = new DateTime();
echo "starting purge : ".$dateNow->format('Y-m-d H:i:s')."\n\n";

require("config.php");
$configPurge = $config['service-purge'];

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

if( isset($configPurge['simulationMode']) && $configPurge['simulationMode'] === false) {
  foreach ($filesToDelete as $file) {
    $result = @unlink($file);
    echo "file : $file - deleted : " . ($result === true ? 'SUCCESS' : 'FAILURE'). "\n";
  }
} else {
  echo "simulation mode : ON\nNo file deleted\n";
}




exit(0);

// sort files by modification time and get the latest one
//
$files = array_combine($files, array_map("filemtime", $files));
arsort($files);
$latest_file = key($files); // bingo !
$newTs = filemtime($latest_file);

// compare the last modification time of the file found with the one previously
// stored (if any)
//
if( ! file_exists($dataFile)){
  file_put_contents($dataFile, $newTs);
  echo "no data file found : creating one<br/>";
} else {
  echo "reading existing timestamp and comparing<br/>";
  $previousTs = file_get_contents($dataFile);
  if( $previousTs == $newTs )
  {
    echo "nothing new : bye bye !<br/>";
  }
  else
  {
    echo "update required : sms will be sent<br/>";
    file_put_contents($dataFile, $newTs);

    // creation message SMS ////////////////////////////////////////////////////
    //
    $date = new DateTime("@".$newTs);
    $date->setTimezone(new DateTimeZone($config['timezone']));
    $timeStr = $date->format('H:i');
    //$imageUrl = $config['baseUrl'] . '/' . $config['folderImg'] . '/' . basename($latest_file);
    $imageUrl = $configPurge['viewImageUrl'] . '?file=' . basename($latest_file);
    echo "image url = $imageUrl<br/>";

  	// invoking URL shortener
  	//
  	require_once('lib/GoogleUrlApi.php');

  	$googer = new GoogleURLAPI($configPurge['google-apikey']);
  	$shortDWName = $googer->shorten($imageUrl);

  	// building final SMS message
  	//
    $message = "San Luis $timeStr : nouvelle image $shortDWName";
    echo "SMS = $message<br/>";

    // sending SMS
    //
    require("lib/FreemobileNotificationSender.php");
    foreach ($configPurge['destinations'] as $key => $dest) {
      try {

        $fms = new FreemobileNotificationSender($dest['sms-userid'],$dest['sms-apikey']);
        $fms->sendMessage($message);
        echo "SMS OK to ".$dest['sms-userid']."<br/>";

      } catch (Exception $e) {
        $errMsg = "erreur for userid = ".$dest['sms-userid']." : ".$e->getMessage(). " code = ". $e->getCode();
        echo "SMS ERROR = $errMsg<br/>";
        file_put_contents("sms-error.log", $errMsg);
      }
    }
  }
}
