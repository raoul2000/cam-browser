<?php

$config = [
  'baseFolder' => __DIR__ . '/explorer',
  'baseUrl'    => 'http://localhost/dev/cam-browser/explorer',

  // name of the folder where images are located. It must be relative
  // to the current folder
  'folderImg'   => "test/data-sample/images",
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
