<?php
$ip = $_SERVER['REMOTE_ADDR'];
$agent =  $_SERVER['HTTP_USER_AGENT'];
$file    = 'burp.log';
$handle = fopen($file, 'a');
fputs($handle, "BURP [IP: $ip, UA: $agent\n\n");
fclose($handle);
?>
 
