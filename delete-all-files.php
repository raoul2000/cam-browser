<?php

header('Content-type: application/json');

require_once('config.php');

$folder = __DIR__ . '/' . $config['folder'] . '/' . $config['filePattern'];
$timezone = isset($config['timezone']) && ! empty($config['timezone'])
  ? $config['timezone']
  : null;

if ( isset($_GET['date']) ) {
  $date = $_GET['date'];
} else if( isset($argv[1]) ){
  $date = $argv[1];
} else {
  echo json_encode([
    'error'   => true,
    'message' => 'invalid request'
  ]);
  exit(1);
}

require_once('lib/select-by-day.php');

$files = getFilesByDay($date , $folder , $timezone);

if( count($files) === 0) {
  echo json_encode([
    'error'   => true,
    'message' => 'invalid request : no file available'
  ]);
  exit(1);
}

// actually delete files
$deleteSuccess = [];
$deleteError = [];
foreach ($files as $filename => $filemtime){
  //$result = unlink($filename);
  if( $result === TRUE ) {
    $deleteSuccess[] = $filename;
  } else {
    $deleteError[] = $filename;
  }
}

if( count($deleteError) != 0 ){
  echo json_encode([
    'error' => true,
    //'message' => 'file ' . $fullpath . ' deleted'
    'message' => '' . count($deleteError) . ' file(s) could not be deleted',
    "files" => $deletedError
  ]);
} else {
  echo json_encode([
    'error' => false,
    //'message' => 'file ' . $fullpath . ' deleted'
    'message' => '' . count($deleteSuccess) . ' file(s) deleted',
    "files" => $deleteSuccess
  ]);
}
