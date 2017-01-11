<?php
require_once("../includes/php_init.php");
require_once("../includes/Facturas.php");
$d=date("Y-m-d",strtotime("today-30 days"));
//die($d);

//vencidas
$fac_ven=$Facturas->facturas_vencidas();
$facturas_vencidas="<tbody id='vencidas-content'>";
while ($row=fetch($fac_ven)) {
    $today=strtotime(now());
    $expired=strtotime($row["vencimiento"]);
    $secs_between_dates=$today-$expired;
    $days_expired=ceil($secs_between_dates/86400);
    $fid=$row["id"];
    $restante=$Facturas->cantidad_restante($fid);
    if($restante>0){
        $monto=money($row["cantidad"]);
        $prov=html_prep($row["nombre"]);
        $folio=$row["folio"];
        $fid=$row["id"];
        $facturas_vencidas.="<tr><td><a href='factura_ver.php?f={$fid}'>{$folio}</a></td>";
        $facturas_vencidas.="<td>{$prov}</td>";
        $facturas_vencidas.="<td>{$restante}</td>";
        $facturas_vencidas.="<td>{$days_expired}</td></tr>";
    }
}
//$facturas_vencidas.="</tbody>";

//por vencer
$fpv=$Facturas->facturas_por_vencer();
$facturas_vencer="";
while ($row=fetch($fpv)) {
    $fid=$row["id"];
    $folio=$row["folio"];
    $prov=html_prep($row["nombre"]);
    $restante=$Facturas->cantidad_restante($fid);
    if($restante>0){
        $expired=strtotime($row["vencimiento"]);
        $fived=strtotime("today + 5 days");
        $secs_between_dates=$fived-$expired;
        $days_to_expire=ceil($secs_between_dates/86400);
        $facturas_vencer.="<tr><td><a href='factura_ver.php?f={$fid}'>{$folio}</a></td>";
        $facturas_vencer.="<td>{$prov}</td>";
        $facturas_vencer.="<td>{$restante}</td>";
        $facturas_vencer.="<td>{$days_to_expire}</td></tr>";
    }
}
$facturas_vencer.="</tbody>";
$title="Facturas";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="facturas-vencer">
                <h3>Facturas por vencer</h3>
                <span class="text-muted">Menos de 5 días</span>
                <table class="table table-striped por-vencer-holder">
                    <tr>
                        <th>Folio</th>
                        <th>Proveedor</th>
                        <th>Cantidad</th>
                        <th>Días para vencer</th>
                    </tr>
                    <tr>
                        <?php echo $facturas_vencer; ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="facturas-vencidas">
                <h3>Facturas vencidas</h3>
                <table class="table table-striped vencidas-holder">
                    <tr>
                        <th>Folio</th>
                        <th>Proveedor</th>
                        <th>Restante</th>
                        <th>Días vencida</th>
                    </tr>
                    <tr>
                        <?php echo $facturas_vencidas; ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript">
    $(function(){
        if($('#por-vencer-content').html().trim()===""){
            $('.por-vencer-holder').html('<h3 class="text-center">No tienes facturas por vencer</h3>');
        }

        if($('#vencidas-content').html().trim()===""){
            $('.vencidas-holder').html('<h3 class="text-center">No tienes facturas vencidas. Felicidades.</h3>');
        }
    });
</script>
