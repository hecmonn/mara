<?php
require_once("../includes/php_init.php");
$yest=date("Y-m-d", strtotime("yesterday"));
$tod=date("Y-m-d", strtotime("today"));
$date=isset($_GET["d"])?$_GET["d"]:$yest;
$sql_con="SELECT a.tck1,a.tck2,a.bmx,a.bbjio,a.amex,a.univale,a.coppel,a.cc,a.efe,a.tar,a.corte,a.tot_dia,a.created_date,s.marca,s.plaza,s.ciudad,s.id FROM av a,sucursales s where a.id_suc=s.id AND a.created_date BETWEEN '{$date} 00:00:01' AND '{$date} 23:59:59' ORDER BY s.id";
$res_con=exec_query($sql_con);
$sql_tot="SELECT sum(a.efe) as 'sume',sum(a.tar) as 'sumtar',sum(a.tot_dia) as 'sumdia' FROM av a,sucursales s where a.id_suc=s.id AND a.created_date BETWEEN '{$date} 00:00:01' AND '{$date} 23:59:59'";
$res_tot=exec_query($sql_tot);
while ($row_tots=fetch($res_tot)) {
	$sume=number_format($row_tots["sume"],2,'.',',');
	$sumdia=number_format($row_tots["sumdia"],2,'.',',');
	$sumtar=number_format($row_tots["sumtar"],2,'.',',');
	$out_tots="<tr><td>{$sume}</td>";
	$out_tots.="<td>{$sumtar}</td>";
	$out_tots.="<td>{$sumdia}</td></tr>";
}
$tot=fetch($res_tot);
$total=number_format($tot,2,'.',',');
$output="<tbody id=\"table-conc\">";
while($row=fetch($res_con)){
	$id_t=$row["id"];
	$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
	$output.="<tr><td><a href=\"detalle.php?s=$id_t&d=$date\">".$tienda."</td>";
	$output.="<td>".$row["tck1"]."</td>";
	$output.="<td>".$row["tck2"]."</td>";
	//$output.="<td>$".$row["bmx"]."</td>";
	//$output.="<td>$".$row["bbjio"]."</td>";
	//$output.="<td>$".$row["amex"]."</td>";
	$output.="<td>$".number_format($row["efe"],2,'.',',')."</td>";
	$output.="<td>$".number_format($row["tar"],2,'.',',')."</td>";
	$output.="<td>$".number_format($row["corte"],2,'.',',')."</td>";
	$output.="<td><strong>$".number_format($row["tot_dia"],2,'.',',')."</strong></td></tr>";
}
$output.="</tbody>";
$title="Concentrado diario";
require_once("../includes/header.php");
?>
<h4>Venta del </h4>
<?php echo strftime('%e %B %G', strtotime($date)); ?>
<a href="diario.php?d= <?php echo $tod; ?>" class="pull-right">HOY</a><br><br>
<div id="conc-data">
	<table class="table table-striped">
		<tr>
			<th rowspan="2" style="text-align:center;">Tienda</th>
			<th colspan="2">Tickets</th>
			<th colspan="4">Totales</th>
		</tr>
		<tr>
			<th>Inicial</th>
			<th>Final</th>
			<th>Efectivo</th>
			<th>Tarjetas</th>
			<th>Corte</th>
			<th>Venta del día</th>
		</tr>
			<?php echo $output; ?>
	</table>
	<table class="table table-striped">
		<tr><th colspan="3"></th></tr>
		<tr>
			<th>Efectivo</th>
			<th>Tarjeta</th>
			<th>Total</th>
		</tr>
		<?php echo $out_tots; ?>
	</table>
</div>

<?php require_once("../includes/footer.php"); ?><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	var infoTable=$('#table-conc').html().trim();
	if(infoTable===""){
		$('#conc-data').html("<h3 class=\"text-center\">No se han ingresado ventas este día</h3>");
	}
});
</script>
<script type="text/javascript"></script>
