<?php

// prepare data-sample folder
$testFolder = __DIR__ . '/data-sample';

$sampleFiles = [
  [
    'name' => "file1.txt",
    'mtime' => "2016/01/28"
  ],
  [
    'name' => "file2.txt",
    'mtime' => "2016/01/28"
  ],
  [
    'name' => "file3.txt",
    'mtime' => "2015/12/01"
  ]
];

foreach($sampleFiles as $file) {
  touch( $testFolder. '/' . $file['name'], strtotime($file['mtime']));
}

// perform test getIndexByDay
require_once('browse-folder.php');
$result = getIndexByDay("$testFolder/*.txt", 'Pacific/Chatham' );
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
$result = getFilesByDay("20160128", "$testFolder/*.txt", 'Pacific/Chatham' );
//print_r($result);
if( count($result) != 2  ) {
      echo "error";
    } else {
      echo "success";
    }
