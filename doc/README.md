# Configuration

The configuration is defined into the file `config.php` located at the root of the project. It is actually a PHP script that defines the **$config** array which is then used by other PHP scripts.

Below is a commented configuration file :

```php

<?php

$config = [
  // this is the base folder where images/video files are saved
  'baseFolder' => __DIR__ . '/explorer',

  // This is the base URL used to preview images/vdeo files
  'baseUrl'    => 'http://localhost/dev/cam-browser/explorer',

  // name of the folder where images/video are located. It must be relative
  // to the base folder parameter configured above.
  'folderImg'   => "snapshots",
  'folderVideo' => "video",

  // file pattern to search for in the folder
  'imageFilePattern' => "*.jpg",
  'videoFilePattern' => "*.mkv",

  // timezone adjustment applied to the file last modification date
  // timezone support in php : http://php.net/manual/fr/timezones.php
  'timezone' => "Pacific/Chatham"
];
```

# Services

The web application comes with services :

- **sms** : send an sms when a new image is detected
- **purge** : perform purge of old image and video

Each service is located in its own folder independently of the other. Each service defines its own configuration settings which are added to the global configuration settings.

## sms service

The configuration of the SMS services is done by adding the **service-sms** key to the application configuration array.

```php
<?php

// define your own configuration or use the one belonging to the cam-browser
// project.
//
require_once('../../config.php');

// config service sms specific

$config['service-sms'] = [
  // Url of the image browser page
  'explorerUrl' => "http://localhost/dev/cam-browser/explorer/",

  // Url of a page displaying the image that triggered the alert. This page includes
  // a link to the Image Browser Page
  'viewImageUrl' => "http://localhost/dev/cam-browser/service/sms/view-image.php/",

  // url shortener Service key
  'google-apikey' => 'XXXXX-XXXXX',

  // SMS destinations (only works with free.fr French service)
  'destinations' => [
    [  "sms-userid" => 'AXXXXX',  'sms-apikey' => 'YYYYYYYY' ],
    [  "sms-userid" => 'BXXXXX',  'sms-apikey' => 'YYYYYYYY' ]
  ]
];
```
## purge service

The configuration of the SMS services is done by adding the **service-purge** key to the application configuration array.

```php
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
  'simulationMode' => true,
];
```
