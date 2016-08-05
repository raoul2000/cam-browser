<?php

$deployIniTemplate =  __DIR__ . "/deploy.ini.template";

// validate command line argument
// The command line must contain the environment name to create
if( ! isset($argv[1])){
  echo "missing environment name\n";
  exit(1);
}

$envName = $argv[1];

echo "environment : $envName\n";

$envConfigFilename = __DIR__ . "/$envName.conf";

if( ! file_exists($envConfigFilename)){
  echo "configuration file not found : $envConfigFilename\n";
  exit(1);
}

require_once($envConfigFilename);

echo "loading configuration file from :  $envConfigFilename\n";
if( !isset($env)){
  echo "incorrect env configuration in file $envConfigFilename\n";
  exit(1);
}

$config = file_get_contents($deployIniTemplate);
$config = strtr($config, $env);

$iniFilename = __DIR__ . "/$envName.ini";

echo "creating deployment ini file $iniFilename ... \n";

if( file_put_contents($iniFilename, $config) === FALSE) {
  echo "failed to create deployment ini file\n";
  exit(1);
}

$scriptFilename = __DIR__ . "/$envName.bat";

$startScriptContent =<<<EOS
@ECHO OFF
vendor/bin/deployment.bat deploy/{$envName}.ini
EOS;

echo "creating startup script : $scriptFilename ... \n";

if( file_put_contents($scriptFilename, $startScriptContent) === FALSE) {
  echo "failed to create startup script\n";
  exit(1);
}

echo "done\n";
echo "to deploy from the project folder, enter : deploy/$envName\n";
