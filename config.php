<?php

$config = [
  // this is the base folder where images/video files are saved
  'baseFolder' => __DIR__ . '/explorer',

  // This is the base URL used to preview images/vdeo files
  'baseUrl'    => 'http://localhost/dev/cam-browser/explorer',

  // name of the folder where images/video are located. It must be relative
  // to the base folder parameter configured above.
  'folderImg'   => "test/data-sample/images",
  'folderVideo' => "test/data-sample/video",

  // file pattern to search for in the folder
  'imageFilePattern' => "*.jpg",
  'videoFilePattern' => "*.mkv",

  // timezone adjustment applied to the file last modification date
  // timezone support in php : http://php.net/manual/fr/timezones.php
  'timezone' => "Pacific/Chatham"
];
