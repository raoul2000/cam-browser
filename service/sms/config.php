<?php

// define your own configuration or use the one belonging to the cam-browser
// project.
//
require_once('../../config.php');

// inject some specific configuration settings into the global config
// Url of the image browser page
$config['explorerUrl'] = "http://localhost/dev/cam-browser/explorer/";

// Url of a page displaying the image that triggered the alert. This page includes
// a link to the Image Browser Page
$config['viewImageUrl'] = "http://localhost/dev/cam-browser/service/sms/view-image.php/";

/*
$config = [
  'baseFolder' => __DIR__,
  'baseUrl'    => 'http://localhost/dev/cam-browser',

  // name of the folder where images are located. It must be relative
  // to the current folder
  'folderImg' => "test/data-sample/images",
  'folderVideo' => "test/data-sample/video",

  // file pattern to search for in the folder
  'imageFilePattern' => "*.jpg",
  'videoFilePattern' => "*.mkv",

  // timezone adjustment applied to the file last modification date
  // timezone support in php : http://php.net/manual/fr/timezones.php
  'timezone' => "Pacific/Chatham",

  // following parameters are only required by the service/SMS alerter.
  // SMS service provided by free.Fr
  "sms-userid" => 'XXXXXX',
  'sms-apikey' => 'XXXXXXXX',

  // url shortener Service key
  'google-apikey' => 'XXXXX-XXXXX'
];
*/
