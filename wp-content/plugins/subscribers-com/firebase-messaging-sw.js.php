<?php
require("config.php");
header("Content-Type: application/javascript");
?>
var version = '1.5';
importScripts("https://<?php echo $subscribers_cdn_host; ?>/assets/subscribers-sw.js");
