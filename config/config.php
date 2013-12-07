<?php

if (!defined('FRAMEWORK_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit('No direct script access allowed!'); 
}

define (APP_PATH, '');
define (FW_PATH_ABS, $_SERVER['DOCUMENT_ROOT'].'/'.APP_PATH.'/');
define (FW_PATH_REL, '/'.APP_PATH.'/');
define (APP_DIR, 'application/');
define (LIB_DIR, 'libraries/');
define (TPL_DIR, 'templates/');

?>
