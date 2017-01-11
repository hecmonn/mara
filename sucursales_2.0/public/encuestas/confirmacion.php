<?php
require_once("../../includes/php_init.php");
$name=$_GET["n"];
$title="Confirmación";
require_once("header_enc.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="holder" style="display:inline-block; vertical-align:middle;">
                <img src="../images/logo.png" class="logo-header center-block" alt="" />
                <h1 class="text-center">¡Gracias por tu tiempo, <?php echo $name; ?>!</h1><br>
                <a href="encuestas.php" class="btn btn-default btn-lg center-block">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<?php require_once("footer_enc.php"); ?>
