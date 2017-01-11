<?php
require_once("../includes/php_init.php");
if(!isset($_SESSION["id_admin"])){
	redirect_to("../public/login.php");
}
//die(var_dump($_SESSION));
$un=(string)$_SESSION['user_admin'];
$flu=strtoupper($un[0].$un[1]);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php  if(isset($title)) echo $title." | "; ?>Mara</title>
        <link rel="stylesheet" href="../public/css/bootstrap.min.css" media="screen" title="bs_style">
        <link rel="stylesheet" href="../public/css/style.css" media="screen" title="genera_style">
    </head>
    <body>
        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index">
                        <div class="logo">Mara</div>
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index">Home</a></li>
                        <li class="dropdown">
                            <a href="index" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="empleados">Empelados</a></li>
                                <li><a href="sucursales">Sucursales</a></li>
                                <li><a href="proveedores">Proovedores</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="nomina" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nómina <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="nomina">General</a></li>
                                <li><a href="nom_con">Concentrado</a></li>
                                <li><a href="adeudos">Adeudos</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Análisis <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="diario">Diario</a></li>
                                <li><a href="conc_tienda">Concentrado por tienda</a></li>
                                <li><a href="#">Concentrado por día</a></li>
                                <li><a href="#">Concentrado por razón social</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Facturas <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="facturas">General</a></li>
                                <li><a href="factura_nueva">Agregar factura</a></li>
                                <li><a href="estado_cuenta">Estado de cuenta</a></li>
                                <li><a href="factura_proveedor">Concentrado por proveedor</a></li>
                                <li><a href="factura_rs">Concentrado por razón social</a></li>
                                <li><a href="concentadro_fecha">Concentrado por fecha</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Metas <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="captura_metas">Captura</a></li>
                                <li><a href="metas">Estadísticos</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $flu; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="text-muted"><?php echo $_SESSION['user_admin']; ?></a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../includes/logout.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="header-title">
            <div class="container">
                <p class="text-center"><?php echo session_message(); ?></p>
                <h2 class="text-center"><?php  if(isset($title)) echo $title; ?></h2>
                <h3 class="text-center"><?php if(isset($subtitle)){echo ($subtitle);} ?></h3>
            </div>
        </div>
        <div class="containter global-holder"> <!--closes in footer-->
            <div class="col-md-10 col-md-offset-1"> <!--closes in footer-->
