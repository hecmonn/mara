<?php  
require_once("../includes/php_init.php");
$s=$_GET["s"];
if(isset($_GET["d"])){
	$dat=$_GET["d"];
	$sql_det="SELECT * FROM av WHERE id_suc={$s} AND created_date BETWEEN '{$dat} 00:00:01' AND '{$dat} 23:59:59'";
}
else {
	$sql_det="SELECT * FROM av WHERE id_suc={$s} ORDER BY created_date DESC LIMIT 1";
}
$res_det=exec_query($sql_det);
while($row=fetch($res_det)){
        $id_av=$row["id"];
	$tck1=$row["tck1"];
	$tck2=$row["tck2"];
	$bmx=number_format($row["bmx"],2,'.',',');
	$bbjio=number_format($row["bbjio"],2,'.',',');
	$amex=number_format($row["amex"],2,'.',',');
	$san=number_format($row["santander"],2,'.',',');
	$sb=number_format($row["sb"],2,'.',',');
	$mc=number_format($row["mc"],2,'.',',');
	$univale=number_format($row["univale"],2,'.',',');
	$coppel=number_format($row["coppel"],2,'.',',');
	$cc=number_format($row["cc"],2,'.',',');
	$efe=number_format($row["efe"],2,'.',',');
	$tar=number_format($row["tar"],2,'.',',');
	$corte=number_format($row["corte"],2,'.','');
	$tot_dia=number_format($row["tot_dia"],2,'.','');
	$created_date=strftime("%e %B %G/%I:%M:%S %P",strtotime($row["created_date"]));
	$dif=$corte-$tot_dia;
}
$sql_gas="SELECT * FROM gastos WHERE id_av={$id_av}";
$res_gas=exec_query($sql_gas);
$output="";
while ($row=fetch($res_gas)) {
	$output.="<tr><td>".$row["descr"]."</td>";
	$output.="<td>".$row["cantidad"]."</td></tr>";
}
$title="Venta detallada";
require_once("../includes/header.php");
?>
<div class="col-md-12">
	<div class="row">
	<h2>Tickets</h2>
		<div class="col-md-3">
			<h3>Ticket inicial: <?php echo $tck1; ?></h3>
		</div>
		<div class="col-md-3">
			<h3>Ticket final: <?php echo $tck2; ?></h3>
		</div>
		<div class="col-md-6">
			<h3 class="pull-right"><?php echo $created_date; ?></h3>
		</div>
	</div>
</div>
<div class="col-md-4">
	<h2>Tarjetas</h2><hr>
	<h3>Banamex $<?php echo $bmx; ?></h3>
	<h3>BanBajio $<?php echo $bbjio; ?></h3>
	<h3>American Express $<?php echo $amex; ?></h3>
	<h3>Santander $<?php echo $san; ?></h3>
	<h3>Scotia Bank $<?php echo $sb; ?></h3>
</div>
<div class="col-md-4">
	<h2>Formas de pago</h2><hr>
	<h3>MoneyCard $<?php echo $mc; ?></h3>
	<h3>Univale $<?php echo $univale; ?></h3>
	<h3>Coppel $<?php echo $coppel; ?></h3>
	<h3>CouponCloud $<?php echo $cc; ?></h3>
</div>
<div class="col-md-4">
	<h2>Totales</h2><hr>
	<h3>Efectivo $<?php echo $efe; ?></h3>
	<h3>Tarjetas $<?php echo $tar; ?></h3><hr>
	<h3 class="total">Corte de caja $<span id="cc"><?php echo $corte; ?></span></h3>
	<h3 class="total"><strong>Venta total $<span id="tot"><?php echo $tot_dia; ?></span></strong></h3>
	<span id="dif"><h3></h3></span>
</div><br><br>
<div id="gas-holder">
<div class="col-md-12">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-striped">
				<tr>
					<th>Descripción</th>
					<th>Cantidad</th>
				</tr>
				<div id="gas-cont">
					<?php echo $output; ?>
				</div>
			</table>
		</div>
	</div>
</div>
</div>
<?php require_once("../includes/footer.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var cc=parseFloat($('#cc').html());
		var tot=parseFloat($('#tot').html());
		var dif=cc-tot;
		if(dif>0){
			$('#dif').css('color','green');
			$('#dif h3').html("Sobrante de $"+dif.toFixed(2));
		} else if(dif<0) {
			$('#dif').css('color','red');
			$('#dif h3').html("Faltante de $"+dif.toFixed(2));
		}
		else{
			$('#dif').html("");
		}
                var gasHolder=$('#gas-holder');
	        var gasCont=$('#gas-cont');
	        if(gasCont.html()==gasCont.html('')){
		        gasHolder.html("");
	        }
	})
</script>