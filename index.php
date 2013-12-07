<?php

define('FRAMEWORK_VERSION', '0.0.1');

if (!defined('FRAMEWORK_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit('No direct script access allowed!'); 
}

header('content-type: text/html; charset=utf-8');

require_once('config/config.php');
require_once(LIB_DIR.'parser.php');

$TPL = new TemplateParser(TPL_DIR, 'container');$TPLid++;
$TPL->assigntpl(TPL_DIR,'TPL:Header', 'header', $TPLid);$TPLid++;
	
require_once(APP_DIR.'controller.php');
	
$TPL->assigntpl(TPL_DIR,'TPL:Footer', 'footer', $TPLid);$TPLid++;
echo $TPL->out();

?>
