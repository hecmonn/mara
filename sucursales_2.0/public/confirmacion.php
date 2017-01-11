<?php
require_once("../includes/php_init.php");
//die(var_dump($_GET));
$tot=money_format('%i',$_GET["t"]);
$ef=money_format('%i',$_GET["e"]);
//$of=$_GET["o"];
$tar=money_format('%i',$_GET["tar"]);
$t1=$_GET["t1"];
$t2=$_GET["t2"];
$si=$_SESSION["id_sucursal"];
$sql_si="SELECT * FROM sucursales WHERE id={$si}";
$res_si=exec_query($sql_si);
while ($row=fetch($res_si)) {
    $tienda=tienda($row);
}
$cd=date("l d F",strtotime("today"));
$title="Confirmación";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
            <h4>Gracias por capturar la venta de <?php echo $tienda; ?></h4>
            <h5 class="text-muted">Para el dia <?php echo $cd ?></h5>
            <h4>Resumen de venta</h4><hr>
            <h4>Tickets</h4>
            <p>Del <?php echo $t1; ?> al <?php echo $t2; ?></p>
            <h4>Totales</h4>
            <p>Efectivo: <?php echo $ef; ?></p>
            <p>Tarjetas: <?php echo $tar; ?></p>
            <p>Total del día: <?php echo $tot; ?></p>
            <p class="text-muted"> Favor de no volver a capturar este día</p>
            <a href="index" class="btn btn-md btn-default">Aceptar</a>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
