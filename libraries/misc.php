<?php

if (!defined('FRAMEWORK_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit('No direct script access allowed!'); 
}

#
# Timestamps
#
$timestamp = time();
$mysqlTimestamp = date("Y-m-d H:i:s",time());

#
# Delete single key from array
#
function delArrayKey($a_aArray, $a_iDelIndex) {
  $l_aNew = array();
  for($i=0;$i<count($a_aArray); $i++) {
    if($i!=$a_iDelIndex) {
    $l_aNew[] = $a_aArray[$i];
    }
  }
  return $l_aNew;
}

if(DEBUG == TRUE) {
	$debug->insert("GLOBALS","loaded", TRUE);
}
?>
