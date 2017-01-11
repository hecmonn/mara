<?php
require_once("../php_init.php");
$fid=(int)$_POST["folio"];
$sql="SELECT * FROM pagos WHERE id_fac={$fid}";
$res=exec_query($sql);
$output="<tbody id='pagos-content'>";
while ($row=fetch($res)) {
    $restante=$row["restante"];
    $fecha=std_date($row["created_date"]);
    $pago=money($row["pago"]);
    $output.="<tr><td>{$fecha}</td>";
    $output.="<td>{$pago}</td>";
    $output.="<td>{$restante}</td></tr>";
}
$output.="</tbody>";
echo $output;
?>
