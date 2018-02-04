## The Story

I had to install an [IP camera](http://www.foscam.com/) some weeks ago and among available features, it can perform movement detection : when a movement is detected, some photo (snapshot) and a video are created and saved to an FTP folder. Cool ! I though I could configure this feature and that's what I did. Everything worked fine but I had no way to take a look to the images/video that were taken on movement detection. The solution was to simply create this **very basic** web app.

## Feature list

- [x] basic HTTP Authentication
- [x] view images(jpg) and video(mkv) created by the cam on movement detection
- [x] navigate by date folders
- [x] add support to time zone
- [x] manual delete selected image and video
- [x] manual delete image and video per date
- [x] SMS notification on movement detection - [free.Fr](http://www.free.fr) only
- [x] automatics purge files (dedicated service)
- [ ] validate configuration on startup
- [ ] manage more than one single home camera

## Requirements

No DB needed, no framework, Just PHP >= 5.2 and you're good to go !

## Screenshots

Here is how the current webapp looks like.

<img src="doc/image/list.jpg" width="70%" />

<img src="doc/image/thumbnails.jpg" width="70%"/>

<img src="doc/image/fullscreen.jpg" width="70%"/>

## Build

Requirements :
- php >= 5.2
- composer

```
git clone https://github.com/raoul2000/cam-browser.git
cd cam-browser
composer install
```

NOTE : the *composer* package installed is [dg/ftp-deployment](https://github.com/dg/ftp-deployment) which is only needed to deploy automatically the project
on an FTP folder (see next chapter).

## Deploy FTP

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


## Configuration

[learn more about configuration](doc/README.md)
