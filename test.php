<?php

// prepare data-sample folder
$testFolder = __DIR__ . '/data-sample';
$refFilename = "img-ref.jpg";
$sampleFiles = [
  [
    'name' => "file1.jpg",
    'mtime' => "2016/01/28 17:23"
  ],
  [
    'name' => "file2.jpg",
    'mtime' => "2016/01/28 12:30"
  ],
  [
    'name' => "file3.jpg",
    'mtime' => "2015/12/01 22:54"
  ]
];

foreach($sampleFiles as $file) {
  $destFile = $testFolder . '/' . $file['name'];
  copy($refFilename, $destFile);
  touch( $destFile, strtotime($file['mtime']));
}

// perform test getIndexByDay
require_once('browse-folder.php');
$result = getIndexByDay("$testFolder/*.jpg", 'Pacific/Chatham' );
//print_r($result);
if( count($result) != 2 ||
    $result['20160128'] != 2 ||
    $result['20151201'] != 1  ) {
      echo "error";
    } else {
      echo "success";
    }

echo "\n";

// perform test getFilesByDay
require_once('select-by-day.php');
$result = getFilesByDay("20160128", "$testFolder/*.jpg", 'Pacific/Chatham' );
//print_r($result);
if( count($result) != 2  ) {
      echo "error";
    } else {
      echo "success";
    }
