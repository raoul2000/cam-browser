<?php


	// invoking URL shortener

define('GOOGLE_APIKEY','XXXXX-XXXXX');

	require_once('../lib/GoogleUrlApi.php');

	$googer = new GoogleURLAPI(GOOGLE_APIKEY);
	$shortDWName = $googer->shorten("http://www.google.fr");
	echo "shortDWName : $shortDWName";
