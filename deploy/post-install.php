<?php


$autPwdFilename= realpath('../lib') . '/.htpasswd';
$htaccessFilename= realpath('..') . '/.htaccess';

if( ! file_exists($autPwdFilename)  ) {
  echo ".htpasswd file nout found in ../lib : creating ...<br/>";
  touch($autPwdFilename);
  $clearTextPassword = '123456';

  // Encrypt password
  //$password = crypt($clearTextPassword, base64_encode($clearTextPassword));
  $password = base64_encode(sha1($clearTextPassword, true));
  file_put_contents($autPwdFilename, "admin:{SHA}$password");
} else {
  echo ".htpasswd file exist : $autPwdFilename (not modified)<br/>";
}

  $htaccessContent="AuthName \"Page d'administration protégée\"\n"
  . "AuthType Basic\n"
  ."AuthUserFile $autPwdFilename\n"
  ."Require valid-user";

  echo "updating file $htaccessFilename\n";
  file_put_contents($htaccessFilename,$htaccessContent);
  if( unlink(__FILE__) === false){
    echo "ERROR : failed to delete file " . __FILE__. "\n";
  } else {
    echo "deleting deploy folder\n";
    rmdir(__DIR__);
  }
  echo "(weak) Protection enabled";
?>
