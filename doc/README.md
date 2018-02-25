# Overview

The webapp is divided in 3 parts :

- the **[Snapshot Explorer](explorer.md)** : a basic file explorer that show snapshots and video files grouped
by day of creation
- the **[Monitor](monitor.md)** : because in my case the webcam doesn't have a static IP, the monitor is used to get the latest dynamic IP and access various web interface like the webcam main page (or any other web page that would be available).
- **Services** : features with no user interface designed to be launched periodically
through a web cron service for instance. Currently 3 services are available :
  - [SMS](service-sms.md)   : send an SMS using free.fr SMS service, when a new snapshot is created
  - [Purge](service-purge.md) : remove files older than a configurable amount of days

Services should be invoked through their respective URL, using (for example) an online cron service ( for example [cronless](https://cronless.com/), a free service with no renew period but limited to 2 jobs at this time 09-2016).


## Installation

### Requirements

No DB needed, no framework, Just PHP >= 5.2 and you're good to go !

### Build

Requirements :
- php >= 5.2
- composer

```

git clone https://github.com/raoul2000/san-luis-control.git
cd san-luis-control
composer install
```

NOTE : the *composer* package installed is [dg/ftp-deployment](https://github.com/dg/ftp-deployment) which is only needed to deploy automatically the project
on an FTP folder (see next chapter).

### Deploy FTP

FTP deployment is managed by [ftp deployment](https://github.com/dg/ftp-deployment) which is included
in the *composer* dependencies.

To setup a *stage* deployment process :

- duplicate the environment configuration file :
```
cp deploy\environment.conf.example deploy\stage.conf
```
- update your `deploy\stage.conf` file
- generate the deployment scripts with `php deploy\create.php stage`
- start deployment with `vendor/bin/deployment - deploy/prod.ini`

You can also run a deployement in simulation (test) mode :

```
vendor/bin/deployment -t deploy/prod.ini
```
