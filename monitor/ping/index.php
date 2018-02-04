<?php
  /**
   * This script is called periodically by the device to inform it is still up
   * and running.
   * Exemple : HTTP GET http://hostname/monitor/ping
   *
   */
  $time = time();
  $check = $time+date("Z",$time);
  $ts = strftime("%B %d, %Y @ %H:%M:%S UTC", $check);

  $data = ' { "time" : "'.$ts.'", "ts" : '.$time.', "ip" : "'.$_SERVER['REMOTE_ADDR'] .'" , "port" : '.$_SERVER['REMOTE_PORT'].'} ';

  file_put_contents(__DIR__ . "/ping.db", $data);
  file_put_contents(__DIR__ . "/ping-verbose.db", "---------------------\n".$ts . ":". print_r($_SERVER,true));

  echo "pong !";
