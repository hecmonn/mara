<?php 
require_once("Session.php");
require_once("functions.php");
$_SESSION["id_sucursal"]=null;
$_SESSION["user_sucursal"]=null;
redirect_to("../public/login.php");
?>