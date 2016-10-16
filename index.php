<?php
$request = $_SERVER['HTTP_REQUEST'];

$code = preg_match('%msg.php\?c=(.*?)%', $request, $matches);

die(var_dump($code));
