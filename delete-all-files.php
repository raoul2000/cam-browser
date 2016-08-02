<?php


$result = [
  'error' => false,
  //'message' => 'file ' . $fullpath . ' deleted'
  'message' => '12 file(s) deleted'
];
header('Content-type: application/json');
echo json_encode($result);
