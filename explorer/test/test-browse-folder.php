<?php
// timezone support in php : http://php.net/manual/fr/timezones.php
// prepare data-sample folder

$testFolder = __DIR__ . '/data-sample';
$refFilename = "img-ref.jpg";
$timezone = "Europe/Paris";

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
    'name' => "file2a.jpg",
    'mtime' => "2016/01/28 21:30"
  ],
  [
    'name' => "file3.jpg",
    'mtime' => "2015/12/01 22:54"
  ]
];

@mkdir($testFolder, 0755);

foreach($sampleFiles as $file) {
  $destFile = $testFolder . '/' . $file['name'];
  copy($refFilename, $destFile);
  touch( $destFile, strtotime($file['mtime']));
}

// perform test getIndexByDay
require_once('../lib/browse-folder.php');
$result = getIndexByDay("$testFolder/*.jpg", $timezone );
//print_r($result);
if( count($result) != 2 ||
    $result['20160128'] != 3 ||
    $result['20151201'] != 1  ) {
      echo "error";
    } else {
      echo "success";
    }
