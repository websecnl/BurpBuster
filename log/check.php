<?php
$secret = $_GET["secret"];
$htaccess = '.htaccess';

if (strpos($secret, 'burp') !== false) {
    header('Location: https://gratispentest.nl/block.php');
} else {
    echo 'false';
}
?>
