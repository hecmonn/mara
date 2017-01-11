<?php
require_once("../../includes/php_init.php");
require_once("../../includes/Encuestas.php");
if(isset($_POST["submit"])){
    $_POST["sid"]=$_SESSION["id_sucursal"];
    $ne=$Encuestas->create();
    if($ne){
        $_SESSION["message"]="Gracias por tu tiempo";
        redirect_to("confirmacion.php?n={$_POST['nombre']}");
    }
}
$title="Encuesta";
require_once("header_enc.php");
?>
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 encuesta-holder" style="padding: 2em;">
                <img src="../images/logo.png" alt="MARA LOGO" class="logo-header center-block"/><br><br>
                <h2 class="text-center">Encuesta de satisfacción</h2>
                <form action="encuestas.php" method="post">
                    <label for="frecuencia" class="questions">¿Con que frecuencia nos visitas?</label><hr>
                    <input type="radio" name="frecuencia" value="0">
                    <label for="">Primera vez</label>
                    <input type="radio" name="frecuencia" value="1">
                    <label for="">Cada mes</label>
                    <input type="radio" name="frecuencia" value="2">
                    <label for="">Cada dos meses</label>
                    <input type="radio" name="frecuencia" value="3">
                    <label for="">Cada tres meses o más</label><br>
                    <label for="razon" class="questions">¿Cuál es la razón principal por la que nos visita?</label><hr>
                    <input type="radio" name="razon" value="surtido">
                    <label for="">Surtido</label>
                    <input type="radio" name="razon" value="atencion al cliente">
                    <label for="">Atención al cliente</label>
                    <input type="radio" name="razon" value="formas de pago">
                    <label for="">Formas de pago</label><br>
                    <div class="col-md-8">
                        <label for="">Otra</label>
                        <input type="text" name="razon" class="form-control">
                    </div>
                    <label for="formas_pago" class="questions">¿Conoce nuestras diferentes formas de pago?</label><hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Sí</label>
                            <input type="radio" name="formas_pago" value="1">
                        </div>
                        <div class="col-md-6">
                            <label for="">No</label>
                            <input type="radio" name="formas_pago" value="0">
                        </div>
                    </div>
                    <label for="metodo_pago" class="questions">¿Qué método de pago utiliza con mayor frecuencia?</label><hr>
                    <label for="">Efectivo</label>
                    <input type="radio" name="metodo_pago" value="efectivo">
                    <label for="">Tarjeta</label>
                    <input type="radio" name="metodo_pago" value="tarjeta">
                    <label for="">Vales</label>
                    <input type="radio" name="metodo_pago" value="vales">
                    <label for="">Crédito</label>
                    <input type="radio" name="metodo_pago" value="credito">
                    <label for="servicio" class="questions">Del 0 al 5 (siendo 5 el más alto) ¿cómo calificaría nuestro servicio?</label><hr>
                    <div class="col-md-8">
                        <input type="number" step="1" name="servicio" class="form-control"><br>
                    </div>
                    <label for="encontro" class="questions">¿Encontró lo que buscaba?</label><hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Sí</label>
                            <input type="radio" name="encontro" value="1">
                        </div>
                        <div class="col-md-6">
                            <label for="">No</label>
                            <input type="radio" name="encontro" value="0">
                        </div>
                    </div>
                    <label for="datos" class="questions">Datos personales</label><hr>
                    <label for="nombre" class="questions">Nombre</label>
                    <input type="text" name="nombre" class="form-control">
                    <label for="edad" class="questions">Edad</label>
                    <input type="number" name="edad" value="" class="form-control">
                    <label for="correo" class="questions">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control">
                    <label for="telefono" class="questions">Teléfono</label>
                    <input type="tel" name="telefono" class="form-control"><br>
                    <input type="submit" name="submit" value="Enviar" class="btn btn-lg btn-success center-block">
                </form>
                <hr>
                <h2 class="text-center">¡Gracias por tu tiempo!</h2>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-3">
                        <img src="../images/kc-logo.png" alt="" class="marcas-imgs"/>
                    </div>
                    <div class="col-md-3">
                        <img src="../images/tbs-logo.png" alt="" class="marcas-imgs"/>
                    </div>
                    <div class="col-md-3">
                        <img src="../images/lacoste-logo.png" alt="" class="marcas-imgs"/>
                    </div>
                    <div class="col-md-3">
                        <img src="../images/benissimo-logo.png" alt="" class="marcas-imgs"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("footer_enc.php"); ?>
