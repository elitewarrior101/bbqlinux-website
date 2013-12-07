<?php

if (!defined('FRAMEWORK_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit('No direct script access allowed!'); 
}

$TPL->assigntpl(TPL_DIR.APP_DIR,'TPL:Content-Left', 'home', $TPLid);$TPLid++;
#$TPL->assign('home',$error,$TPLid);$TPLid++;

?>
