<?php

// define your own configuration or use the one belonging to the cam-browser
// project.
//
require_once('../../config.php');

// config service sms specific

$config['service-purge'] = [
  // number of days images must be kept
  'imageRetentionDays' => 40,

  // number of days video must be kept
  'videoRetentionDays' => 40,

  // when TRUE, no file is actually deleted
  'simulationMode' => false,
];
