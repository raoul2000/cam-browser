
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

FTP deployment is managed by [ftp deployment](https://github.com/dg/ftp-deployment).

To setup a *stage* deployment process :

- duplicate the environment configuration file :
```
cp deploy\environment.conf.example deploy\stage.ini
```
- update your `deploy\stage.ini` file
- generate the deployment scripts `deploy\create.php stage`
- start deployment with `deploy\stage`

## TODO

- rebuild using Yii2 framework
