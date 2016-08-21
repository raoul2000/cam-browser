<?php
require_once('config.php');

// very basic script that deletes the file whose name is received as
// a request GET parameter ('path') assumed to be urlencoded.
//
// Returns a JSON response with the following format :
// success :
// {
//  'error' : false,
//  'message' : "file deleted"
// }
//
// error :
// {
//  "error" : true,
//  "message" : "the error message here"
// }
//
sleep(1);
if ( ! isset($_GET['path'])) {
  $result = [
    'error' => true,
    'message' => 'invalid request'
  ];
} else {

  $path = urldecode($_GET['path']);
  $fullpath =  $config['baseFolder'] . '/' . str_replace('..','',$path);

  if ( ! file_exists($fullpath)) {
    $result = [
      'error' => true,
      'message' => 'file not found : ' . $path
    ];
  } else if (  ! unlink($fullpath)  ) { // ! unlink($fullpath)
    # code...
    $result = [
      'error' => true,
      'message' => 'failed to delete file : ' . $path
    ];
  } else {
    $result = [
      'error' => false,
      'message' => 'file deleted : ' . $path
    ];
  }
}

header('Content-type: application/json');
echo json_encode($result);
