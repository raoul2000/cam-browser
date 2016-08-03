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
  $fullpath = $config['folder'] .'/'. urldecode($_GET['path']);
  if ( ! file_exists($fullpath)) {
    $result = [
      'error' => true,
      'message' => 'file not found : '
    ];
  } else if (  false  ) { // ! unlink($fullpath)
    # code...
    $result = [
      'error' => true,
      //'message' => 'file ' . $fullpath . ' deleted'
      'message' => 'failed to delete file'
    ];
  } else {
    $result = [
      'error' => false,
      //'message' => 'file ' . $fullpath . ' deleted'
      'message' => 'file  deleted'
    ];
  }
}


header('Content-type: application/json');
echo json_encode($result);
