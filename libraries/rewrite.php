<?php

if (!defined('FRAMEWORK_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit('No direct script access allowed!'); 
}

$urlParams = stristr($_SERVER['REQUEST_URI'], "-");
$urlIncludepath = str_replace($urlParams, "", $_SERVER['REQUEST_URI']);

$urlParams = str_ireplace(".html", "", "$urlParams");
$urlIncludepath = str_ireplace(".html", "", "$urlIncludepath");
$urlParams = explode('-', trim($urlParams, '-'));

$i=0;
while ($i <= count($urlParams))
{
	$$urlParams[$i] = $urlParams[$i+1];
	$i = $i+2;
}

$scriptSubdir = str_replace(basename($_SERVER['SCRIPT_NAME']), "", trim($_SERVER['SCRIPT_NAME'], '/'));
$urlIncludepath = str_replace($scriptSubdir, "", $urlIncludepath);

if (!empty($urlIncludepath)) {
	$requestScript = trim($urlIncludepath, '/');
} else {
	$requestScript = '';
}

?>
