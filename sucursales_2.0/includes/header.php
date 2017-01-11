<?php
require_once("../includes/php_init.php");
if(!isset($_SESSION["id_sucursal"])){
	redirect_to("../public/login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php  if(isset($title)) echo $title." | "; ?>Mara</title>
        <link rel="stylesheet" href="../public/css/bootstrap.min.css" media="screen" title="bs_style">
        <link rel="stylesheet" href="../public/css/style.css" media="screen" title="general_style">
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
                        <li class="active"><a href="index">Inicio</a></li>
                        <li class="dropdown">
                            <a href="av" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Análisis <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="av.php?s=<?php echo $tid; ?>">Captura</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="av" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nómina <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="em_nom.php?s=<?php echo $tid; ?>">Captura</a></li>
                            </ul>
                        </li>
                        <li><a href="encuestas/encuestas.php">Encuesta</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $flu; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="text-muted"><?php echo $_SESSION['user_sucursal']; ?></a></li>
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
