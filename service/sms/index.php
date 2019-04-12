<?php
require("config.php");
$configSms = $config['service-sms'];
//var_dump($configSms);

$dataFile = "latest-file.dta";

// Functions /////////////////////////////////////////////////////////////////

function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}


// find file by last modification date ////////////////////////////////////////
//
$dirSnapshot = $config['baseFolder'] . '/' . $config['folderImg'] . '/' . $config['imageFilePattern'];

$files = glob($dirSnapshot) ;
if( count($files) == 0) {
  // no file : exit
  exit(0);
}

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
    $imageUrl = $configSms['viewImageUrl'] . '?file=' . basename($latest_file);
    echo "image url = $imageUrl<br/>";

  	// invoking URL shortener
	
	  $shortDWName = get_tiny_url($imageUrl);

  	// building final SMS message
  	//
    $message = "San Luis $timeStr : nouvelle image $shortDWName";
    echo "SMS = $message<br/>";

    // sending SMS
    //
    require("lib/FreemobileNotificationSender.php");
    foreach ($configSms['destinations'] as $key => $dest) {
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
