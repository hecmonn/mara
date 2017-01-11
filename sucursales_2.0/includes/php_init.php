<?php
require_once("Session.php");
require_once("functions.php");
require_once("Database.php");
setlocale(LC_ALL,"es_MX");
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$tid=(int)$_SESSION['id_sucursal'];
$un=(string)$_SESSION['user_sucursal'];
$flu=strtoupper($un[0].$un[1]);
?>
