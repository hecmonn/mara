<?php
require_once("../includes/php_init.php");
$pid=$_GET["c"];
$sql_p="SELECT * FROM proveedores WHERE id={$pid}";
$res_p=exec_query($sql_p);
while ($row=fetch($res_p)) {
    $pid=$row["id"];
    $persona=html_prep($row["persona"]);
    $concepto=html_prep($row["concepto"]);
    $created_date=std_date($row["created_date"]);
    $direccion=html_prep($row["direccion"]);
    $ciudad=html_prep($row["ciudad"]);
    $pais=html_prep($row["pais"]);
    $rfc=$row["rfc"];
    $contacto=($row["contacto"]);
    $telefono=$row["telefono"];
    $banco=html_prep($row["banco"]);
    $cuenta=$row["cuenta"];
    $clabe=$row["clabe"];
    $nombre=($row["nombre"]);
    $apellido_materno=html_prep($row["apellido_materno"]);
    $apellido_paterno=html_prep($row["apellido_paterno"]);
    $pf=$persona=="Fisica"?"style='display:block'":"style='display:none'";
}
$title=strtoupper($nombre);
require_once("../includes/header.php");
?>
<div class="container" style="font-size:1.2em; line-height: 1.5em;">
    <div class="row">
        <div class="col-md-4">
            <h3>Persona</h3><hr>
            <strong>ID: </strong><?php echo $pid; ?><br>
            <strong>Persona: </strong><?php echo $persona; ?><br>
            <strong>Nombre: </strong><?php echo $nombre; ?><br>
            <div class="persona-fisica" <?php echo $pf; ?>>
                <strong>Apellido materno: </strong><?php echo $apellido_materno; ?><br>
                <strong>Apellido paterno: </strong><?php echo $apellido_paterno; ?><br>
            </div>
            <strong>RFC: </strong><?php echo $rfc; ?><br>
        </div>
        <div class="col-md-4"><br><br><br>
            <strong>Direccion: </strong><?php echo $direccion; ?><br>
            <strong>Ciudad: </strong><?php echo $ciudad; ?><br>
            <strong>País: </strong><?php echo $pais; ?><br>
            <strong>Contacto: </strong><?php echo $contacto; ?><br>
            <strong>Teléfono: </strong><?php echo $telefono; ?><br>
            <strong>Alta: </strong><?php echo $created_date; ?>

        </div>
        <div class="col-md-4">
            <h3>Información de pago</h3><hr>
            <strong>Banco: </strong><?php echo $banco; ?><br>
            <strong>Cuenta: </strong><?php echo $cuenta; ?><br>
            <strong>Clabe: </strong><?php echo $clabe; ?>
            <a href="#"></a>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
