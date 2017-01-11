<?php
require_once("Session.php");
require_once("functions.php");
$_SESSION["id_admin"]=null;
$_SESSION["user_admin"]=null;
redirect_to("../public/login.php");
?>