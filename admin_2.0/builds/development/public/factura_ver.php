<?php
require_once("../includes/php_init.php");
require_once("../includes/Facturas.php");
$fid=(int)$_GET["f"];
if(isset($_POST["submit"])){
    $sql_p="SELECT sum(pago) FROM pagos WHERE id_fac={$fid}";
    $res_p=exec_query($sql_p);
    $pagos=(float)array_shift(fetch($res_p));
    $sql_m="SELECT cantidad FROM facturas WHERE id={$fid}";
    $res_m=exec_query($sql_m);
    $monto=(float)array_shift(fetch($res_m));
    $restante_actual=$monto-$pagos;
    $abono=(float)($_POST["pago"]);
    $monto_actual=$restante_actual-$abono;
    $sql_pago="INSERT INTO pagos(pago,id_fac,restante) VALUES({$abono},{$fid},{$monto_actual})";
    $res_pago=exec_query($sql_pago);
    if($res_pago){
        redirect_to("factura_ver.php?f={$fid}");
    }

}
$sql_f="SELECT f.folio,f.created_date fcd,f.vencimiento,f.cantidad,f.cantidad,p.nombre,p.direccion,p.ciudad,";
$sql_f.=" rs.razon FROM facturas f, razones_sociales rs, proveedores p WHERE f.id={$fid} AND f.id_prov=p.id AND f.id_rs=rs.id";
$res_f=exec_query($sql_f);
while ($row=fetch($res_f)) {
    $folio=$row["folio"];
    $vigente=$Facturas->vigente($row["vencimiento"]);
    $emitida=std_date($row["fcd"]);
    $vencimiento=std_date($row["vencimiento"]);
    $monto=money($row["cantidad"]);
    $prov=html_prep($row["nombre"]);
    $rs=html_prep($row["razon"]);
    $direccion=html_prep($row["direccion"])." ".html_prep($row["ciudad"]).".";
}

//pagos
$restante=$Facturas->cantidad_restante($fid);
$pagos=$Facturas->pagos($fid);
$estado=$Facturas->estado($fid,$vigente);
$output="<tbody id='pagos-table'>";
while ($row=fetch($pagos)) {
    $fecha_pago=std_date($row["created_date"]);
    $monto_pago=money($row["pago"]);
    $restante=money($row["restante"]);
    $liquidada=(float)$row["restante"]<=0;
    $output.="<tr><td>{$fecha_pago}</td>";
    $output.="<td>{$monto_pago}</td>";
    $output.="<td>{$restante}</td></tr>";
}
$output.="</tbody>";
$title="Factura No. {$fid}";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row" style="line-height:2em;">
        <div class="col-md-5 col-md-offset-1">
            <div style="font-size:1.3em"><br>
                <strong>Folio </strong><span>#<?php echo $fid; ?></span><br>
                <strong>Fecha emitida:</strong> <?php echo $emitida; ?><br>
                <strong>Fecha de vencimiento:</strong> <?php echo $vencimiento; ?><br>
                <strong>Monto:</strong> <?php echo $monto; ?> MXN <br>
                <strong>Razón social:</strong> <?php echo $rs; ?>
            </div>
        </div>
        <div class="col-md-5" style="font-size:1.3em">
            <h3 class="pull-right"><?php echo $estado; ?></h3><br><br>
            <strong>Proveedor:</strong> <?php echo $prov;; ?><br>
            <strong>Dirección:</strong> <?php echo $direccion; ?><br>
            <strong>Restante:</strong> <?php echo $restante; ?>
            <h4></h4>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <h3>Pagos</h3>
            <div class="pagos-content">
                <table class="table table-striped">
                    <tr>
                        <th>Fecha de pago</th>
                        <th>Cantidad pagada</th>
                        <th>Cantidad restante</th>
                    </tr>
                    <?php echo $output;?>
                </table>
            </div>
        </div>
        <div class="col-md-5">
            <h4>Abonar</h4>
            <form action="factura_ver.php?f=<?php echo $fid; ?>" method="post">
                <div class="row">
                    <div class="col-md-6"><div class="input-group">
            			<div class="input-group-addon">$</div>
            		          <input type="number" name="pago" step="0.1" min="0.1" class="form-control" required>
            		</div><br>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" name="submit" value="Realizar" class="btn btn-md btn-default">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript">
    $(function(){
        if($('#pagos-table').html().trim()===""){
            $('.pagos-content').html("<h4 class='text-center'>No se han realizado pagos a esta factura</h4>");
        }
    });
</script>
