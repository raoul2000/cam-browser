<?php
require_once('config.php');


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
  } else if (  ! unlink($fullpath) ) {
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
