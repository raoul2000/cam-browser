<?php

// define your own configuration or use the one belonging to the san-luis-control
// project.
//
require_once('../../config.php');

// config service sms specific

$config['service-sms'] = [
  // Url of the image browser page
  'explorerUrl' => "http://localhost/dev/san-luis-control/explorer/",

  // Url of a page displaying the image that triggered the alert. This page includes
  // a link to the Image Browser Page
  'viewImageUrl' => "http://localhost/dev/san-luis-control/service/sms/view-image.php/",

  // url shortener Service key
  'google-apikey' => 'XXXXX-XXXXX',

  // SMS destinations (only works with free.fr French service)
  'destinations' => [
    [  "sms-userid" => 'AXXXXX',  'sms-apikey' => 'YYYYYYYY' ],
    [  "sms-userid" => 'BXXXXX',  'sms-apikey' => 'YYYYYYYY' ]
  ]
];
