<?php
//$json = file_get_contents('http://s326321645.onlinehome.fr/site/ping/san-luis/view.php');
$json = file_get_contents('./ping/ping.db');

$sanLuis = json_decode($json);

$diff = time() - $sanLuis->ts;

if( $diff > 3600) {
  http_response_code(503); // service unavailable
} else {
  http_response_code(200);
}
echo $diff;
