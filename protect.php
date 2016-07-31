<?php

$autPwdFilename= realpath('lib') . '/.htpasswd';

if( file_exists($autPwdFilename) === false ) {
  echo ".htpasswd file nout found in ./lib : please create an restart";
} else {

  $htaccessContent="AuthName \"Page d'administration protégée\"\n"
  . "AuthType Basic\n"
  ."AuthUserFile $autPwdFilename\n"
  ."Require valid-user";

  file_put_contents(".htaccess",$htaccessContent);

  echo "Protection enabled";
}
?>
