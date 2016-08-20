<?php
// timezone support in php : http://php.net/manual/fr/timezones.php
// prepare data-sample folder

$testFolderImages = __DIR__ . '/data-sample/images';
$testFolderVideo = __DIR__ . '/data-sample/video';
$refImageFile = "img-ref.jpg";
$timezone = "Europe/Paris";

$sampleImages = [
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

$sampleVideo = [
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
  ],
  [
    'name' => "file4.jpg",
    'mtime' => "2015/11/01 22:54"
  ],
  [
    'name' => "file5.jpg",
    'mtime' => "2015/11/01 22:54"
  ]
];

function createTestFolder($folder, $sampleFiles, $refFilename) {

  @mkdir($folder, 0755);

  foreach($sampleFiles as $file) {
    $destFile = $folder . '/' . $file['name'];
    copy($refFilename, $destFile);
    touch( $destFile, strtotime($file['mtime']));
  }
}

createTestFolder($testFolderImages, $sampleImages, $refImageFile);
createTestFolder($testFolderVideo, $sampleVideo, $refImageFile);


// perform test getFilesByDay
require_once('../lib/select-by-day.php');
$result = getFilesByDay("20160128", "$testFolderImages/*.jpg", $timezone );
//print_r($result);
if( count($result) != 3  ) {
      echo "error";
    } else {
      echo "success";
    }
