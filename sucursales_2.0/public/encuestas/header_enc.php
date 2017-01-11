<?php
if(session_status()!==PHP_SESSION_ACTIVE) session_start();
if(!isset($_SESSION["id_sucursal"])){
    redirect_to("../login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php  if(isset($title)) echo $title." | "; ?>Mara</title>
        <link rel="stylesheet" href="../../public/css/bootstrap.min.css" media="screen" title="bs_style">
        <link rel="stylesheet" href="../../public/css/style.css" media="screen" title="general_style">
        <style media="screen">
            img.logo-header{
                width: 50%;
                height: 50%;
            }
            input,label{
                padding: 1em
            }
            label{
                font-weight: normal;
            }
            .questions{
                padding-left: 0;
                padding-right: 0;
                font-weight: bold;
                font-size: 1.1em;
                padding-bottom:0;
                padding-top:1.5em;
            }
            img.marcas-imgs{
                width:100%;
                height:100%;
                padding: 0 1em;
            }
            .holder{
                vertical-align: middle;
                height:100%;
                margin-top: 30%;
            }
        </style>
    </head>
    <body>
