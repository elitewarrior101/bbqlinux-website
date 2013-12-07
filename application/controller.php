<?php

if (!defined('FRAMEWORK_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit('No direct script access allowed!'); 
}

$valid = false;

switch ($requestScript)
{
    case 'home':
        $application = 'home';
        $valid = true;
        break;
    default:
        $application = 'home';
        $valid = true;
        break;
}
	
if ($valid == true && is_file(APP_DIR.$application.'.php'))
{
    require_once(APP_DIR.$application.'.php');
}
else
{
    $error['title'] = 'Error';
    $error['message'] = 'File not found!';
		
    $TPL->assigntpl(TPL_DIR,'TPL:Content', 'error', $TPLid);
    $TPL->assign('error',$error,$TPLid);$TPLid++;
}

?>
