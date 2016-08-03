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

foreach ($files as $filename => $filemtime){

}

$result = [
  'error' => false,
  //'message' => 'file ' . $fullpath . ' deleted'
  'message' => '12 file(s) deleted'
];
