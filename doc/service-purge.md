# Purge Service

## Overview

As we don't want to get a *file system full* error, we must periodically delete image and video files : this is the purge.

The purge service must be invoqued periodically by an external process (e.g. a cron) and based on its configuration settings, it will delete files.

## configuration


The configuration of the Purge services is done by adding the **service-purge** key to the application configuration file located in `config.php`.

```php
<?php

// define your own configuration or use the one belonging to the project

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
```
