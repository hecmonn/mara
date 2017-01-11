<?php
require_once("../includes/php_init.php");
$sql="SELECT f.id,f.folio,sum(pa.pago) as 'pagos',sum(f.cantidad) as 'monto',f.id_prov,p.nombre,f.id_rs,rs.razon FROM proveedores p JOIN facturas f ON f.id_prov=p.id";
$sql.=" JOIN razones_sociales rs ON f.id_rs=rs.id LEFT JOIN pagos pa on pa.id_fac=f.id GROUP BY f.id_prov,f.id_rs";
$sql.=" HAVING sum(pa.pago)<=sum(f.cantidad) ORDER BY rs.razon,p.nombre";
die($sql);
$res=exec_query($sql);
$estado_cuenta="";
while ($row=fetch($res)) {
    $prov=html_prep($row["nombre"]);
    $rs=html_prep($row["razon"]);
    $pagos=(float)$row["pagos"];
    $monto=(float)$row["monto"];
    $adeudo=money($monto-$pagos);
    $estado_cuenta.="<tr><td>{$prov}</td>";
    $estado_cuenta.="<td>{$rs}</td>";
    $estado_cuenta.="<td>{$adeudo}</td></tr>";
}
$title="Estado de cuenta";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <a href="../includes/pdf_ec.php" class="pull-right" target="_blank">Exportar</a>
        <table class="table table-striped">
            <tr>
                <th>Proveedor</th>
                <th>Razón</th>
                <th>Cantidad</th>
            </tr>
            <tr>
                <?php echo $estado_cuenta; ?>
            </tr>
        </table>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
