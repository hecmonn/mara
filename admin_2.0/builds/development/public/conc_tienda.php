<?php
require_once("../includes/php_init.php");
$output="";
if(isset($_POST["submit"])){
	$t=$_POST["s"];
	$fs=isset($_POST["ds"])?mysql_prep($_POST["ds"]):date('Y-m-d',strtotime("today"));
	$ff=isset($_POST["df"])?mysql_prep($_POST["df"]):date('Y-m-d',strtotime("today"));
	$sql_con="SELECT a.tck1,a.tck2,a.bmx,a.bbjio,a.amex,a.univale,a.coppel,a.cc,a.efe,a.tar,a.corte,a.tot_dia,a.created_date,s.marca,s.plaza,s.ciudad,a.id FROM av a,sucursales s WhERE a.id_suc=s.id AND s.id={$t} AND a.created_date BETWEEN '{$fs} 00:00:01' AND '{$ff} 23:59:59'";
	$res_con=exec_query($sql_con);
	while($row=fetch($res_con)){
		$id_t=$row["id"];
		$d=$row["created_date"];
		$output.="<tr><td><a href=\"detalle.php?s=$t&d=$d\">".date('Y-m-d',strtotime($d))."</td>";
		$output.="<td>".$id_t."</td>";
		$output.="<td>".$row["tck1"]."</td>";
		$output.="<td>".$row["tck2"]."</td>";
		$output.="<td>$".$row["bmx"]."</td>";
		$output.="<td>$".$row["bbjio"]."</td>";
		$output.="<td>$".$row["amex"]."</td>";
		$output.="<td>$".$row["efe"]."</td>";
		$output.="<td>$".$row["tar"]."</td>";
		$output.="<td>$".$row["corte"]."</td>";
		$output.="<td class=\"total\"><strong>$".$row["tot_dia"]."</strong></td></tr>";
	}
	$sql_t="SELECT * FROM sucursales WHERE id={$t}";
	$res_t=exec_query($sql_t);
	while($row=fetch($res_t)){
		$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
	}
	$sql_tots="SELECT sum(a.efe) as 'sume',sum(a.tar) as 'sumtar',sum(a.tot_dia) as 'sumdia' FROM av a,sucursales s WHERE a.id_suc=s.id AND s.id={$t} AND a.created_date BETWEEN '{$fs} 00:00:01' AND '{$ff} 23:59:59'";
	$res_tots=exec_query($sql_tots);
	while ($row_tots=fetch($res_tots)) {
		$sume=number_format($row_tots["sume"],2,'.',',');
		$sumtar=number_format($row_tots["sumtar"],2,'.',',');
		$sumdia=number_format($row_tots["sumdia"],2,'.',',');
		$output_tots="<tr><td>{$sume}</td>";
		$output_tots.="<td>{$sumtar}</td>";
		$output_tots.="<td>{$sumdia}</td></tr>";
	}
	$subtitle=$tienda."<br>".$fs."/".$ff;
}
$title="Concentrado tienda";
require_once("../includes/header.php");
?>
<form action="conc_tienda.php" method="post">
	<div class="col-md-12">
		<div class="col-md-4">
			<label>Tienda</label>
			<select name="s" class="form-control">
				<?php $sql_t="SELECT * FROM sucursales";
				$res_con=exec_query($sql_t);
				while($row=fetch($res_con)){
					$id=$row["id"];
					$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
					echo "<option value=\"{$id}\">{$tienda}</option>";
				} ?>
			</select><br><br>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-5">
					<label>Del:</label>
					<input type="date" name="ds" value="" class="form-control">
				</div>
				<div class="col-md-5">
					<label>Al:</label>
					<input type="date" name="df" value="" class="form-control">
				</div>
				<div class="col-md-2">
					<br>
					<input type="submit" name="submit" value="Ver" class="btn btn-success"><br><br>
					<a href="../includes/excel_conc.php?s=<?php echo "{$t}&fs={$fs}&ff={$ff}" ?>" class="btn btn-default pull-right">Exportar</a><br><br>
				</div>
			</div>
		</div>
	</div>
</form>
<div id="conc-tab">
<table class="table table-striped">
	<tr>
		<th>Fecha</th>
		<th>ID</th>
		<th colspan="2">Tickets</th>
		<th colspan="3">Tarjetas</th>
		<th colspan="4">Totales</th>
	</tr>
	<tr>
		<th></th>
		<th>ID</th>
		<th>Inicial</th>
		<th>Final</th>
		<th>Banamex</th>
		<th>BanBajio</th>
		<th>American Express</th>
		<th>Efectivo</th>
		<th>Tarjetas</th>
		<th>Corte</th>
		<th>Venta del día</th>
	</tr>
	<div id="data-tab"><?php echo $output; ?></div>
</table>
<table class=" table table-striped">
	<tr><th colspan="3">Totales</th></tr>
	<tr>
		<th>Efectivo</th>
		<th>Tarjetas</th>
		<th>Total</th>
	</tr>
	<?php  if(isset($output_tots)) echo $output_tots; ?>
</table>
</div><br>


<?php require_once("../includes/footer.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
