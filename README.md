## The Story

I had to install an [IP camera](http://www.foscam.com/) some weeks ago and among available features, it can perform movement detection : when a movement is detected, some photo (snapshot) and a video are created and saved to an FTP folder. Cool ! I though I could configure this feature and that's what I did. Everything worked fine but I had no way to take a look to the images/video that were taken on movement detection. The solution was to simply create this **very basic** web app.

## Feature list

- [x] basic HTTP Auhtentication protection
- [x] view images(jpg) and video(mkv) created by the cam on movement detection
- [x] navigate by date folders
- [x] add support to timezone
- [x] manual delete selected image and video
- [x] manual delete image and video per date
- [x] sms notification on movement detection [free.Fr](http://www.free.fr) only
- [ ] manage more than one single home camera

## Requirements

No DB needed !! Just PHP >= 5.2 and you're good to go !

## Build

Requirements :
- php >= 5.2
- composer

```
git clone https://github.com/raoul2000/cam-browser.git
cd cam-browser
composer install
```

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
- start deployment with `deploy\stage`
