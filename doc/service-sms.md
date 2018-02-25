# SMS Notification Service

## Overview

This service scan for new image files and when one is found, sends an SMS alert.
The SMS service used is the one provided for free to all [free.fr](http://www.free.fr) customers.

- endpoint : `http://hostname/san-luis-control/service/sms`

To be enabled , the SMS Service endpoint should be invoked periodically to test if new images is available.

This services uses **Google shortener URL API** to produce a short url that will be included in the alert SMS sent. This API requires a **google-apikey**.


# Configuration

The configuration of the SMS services is done by adding the **service-sms** key to the application configuration file located in `config.php`.

```php
<?php

// define your own configuration or use the one belonging to the project

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
```
