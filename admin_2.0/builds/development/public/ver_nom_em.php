<?php 
require_once("../includes/php_init.php");
$id_e=$_GET["e"];
$quin=isset($_GET["q"])?$_GET["q"]:0;
$sueldo=0;
$comisiones=0;
$descanso=0;
$faltas=0;
$nom_tot=0;
$credifam=0;
$caja_ahorro=0;
$abono=0;
$sql_em="SELECT * FROM nomina WHERE id_em={$id_e} ORDER BY created_date DESC LIMIT 1";
if(isset($_POST["submit"])){
	$quin=$_POST["quin"];
	$sql_em="SELECT * FROM nomina WHERE id_em={$id_e} AND quin ='{$quin}' LIMIT 1";
}
$res_em=exec_query($sql_em);
while ($row=fetch($res_em)) {
	$sueldo=isset($row["sueldo"])? html_prep($row["sueldo"]):0;
	$comisiones=isset($row["comisiones"])? html_prep($row["comisiones"]):0;
	$descanso=isset($row["descanso"])? html_prep($row["descanso"]):0;
	$faltas=isset($row["faltas"])? html_prep($row["faltas"]):0;
	$nom_tot=isset($row["nom_tot"])? html_prep($row["nom_tot"]):0;
	$credifam=isset($row["credifam"])? html_prep($row["credifam"]):0;
	$caja_ahorro=isset($row["caja_ahorro"])? html_prep($row["caja_ahorro"]):0;
	$abono=isset($row["abono"])?html_prep($row["abono"]):0;
	$sb=isset($row["sueldo_base"])?html_prep($row["sueldo_base"]):0;
	$fecha=date("Y-m-d",strtotime($row["quin"]));
}
$sql_e="SELECT e.nombre,e.telefono,e.estado,e.sueldo,e.imss,e.infonavit";
$sql_e.=",e.direccion,e.photo_path,s.marca,s.plaza,s.ciudad";
$sql_e.=",rs.razon FROM empleados e, sucursales s, razones_sociales rs";
$sql_e.=" WHERE e.id={$id_e} AND e.id_suc=s.id AND s.id_rs=rs.id";
$res_e=exec_query($sql_e);
while($row=fetch($res_e)){
	$photo_path=$row["photo_path"];
	$nom=html_prep($row["nombre"]);
	$imss=html_prep($row["imss"]);
	$infonavit=html_prep($row["infonavit"]);
	$sueldo_fis=(float)$row["sueldo"];
	$direccion=html_prep($row["direccion"]);
	$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
}
//quincena
$sd=(float)($sueldo/15);
//$sd=money_format('%i', $sueldo_diario);
$fortnight= quincena();
$fecha=$fortnight[0];
$days_ago=$fortnight[1];
$title="Nomina detallada";
require_once("../includes/header.php");
?>
<div class="row">
	<div class="col-md-2">
		<a href="nom_con.php?q=<?php echo $quin ?>">&laquo;Regresar</a>
		<img src="<?php echo $photo_path; ?>" width="80" height="120">
	</div>
	<div class="col-md-6"><br>
		<h4><strong><?php echo "Nombre: </strong>".$nom; ?></h4>
		<h4><strong><?php echo "Dirección: </strong>".$direccion; ?></h4>
		<h4><strong><?php echo "Tienda: </strong>".$tienda; ?></h4>
	</div>
	<div class="col-md-4">
		<div class="row">
			<div class="col-md-8">
				<form action="ver_nom_em.php?e=<?php echo $id_e ?>" method="post">
					<select name="quin" class="form-control">
						<?php 
							$sql_q="SELECT quin FROM nomina WHERE id_em={$id_e}";
							$res_q=exec_query($sql_q);
							while($row=fetch($res_q)){
								$quin=$row["quin"];
								$fec=date("Y-m-d",strtotime($quin));
								echo "<option value={$quin}>{$fec}</option>";
							}
						?>
					</select>
			</div>
			<div class="col-md-3">
					<input type="submit" name="submit" value="Ver" class="btn btn-default">
				</form>
			</div>
		</div>
		<h4><strong><?php echo "Nomina: </strong>". $fecha; ?></h4>
	</div>
</div><hr>
<div class="row">
	<div class="col-md-4">
		<h4>Sueldo base: <?php echo money_format('%i', $sb); ?></h4>
		<h4>Sueldo fiscal: <?php echo money_format('%i', $sueldo_fis); ?></h4>
		<h4>Comisiones: <?php echo money_format('%i', $comisiones); ?></h4>
		<h4>Abonos: <span class="resta"><?php echo money_format('%i', $abono); ?></span></h4>
	</div>
	<div class="col-md-4">
		<h4>CrediFam: <?php echo money_format('%i', $credifam); ?></h4>
		<h4>Caja Ahorro: <?php echo money_format('%i', $caja_ahorro); ?></h4>
		<h4>IMSS: <?php echo money_format('%i', $imss); ?></h4>
		<h4>Infonavit: <?php echo money_format('%i', $infonavit); ?></h4>
	</div>
	<div class="col-md-4">
		<h4>Faltas: <?php echo $faltas; ?></h4>
		<small><span class="resta"><?php echo money_format('%i',$sd)."x".$faltas."=".money_format('%i', ($sd*$faltas)); ?></span></small>
		<h4>Descansos: <?php echo $descanso; ?></h4>
		<small><span class="total"><?php echo money_format('%i',$sd)."x".$descanso."=".money_format('%i', ($sd*$descanso)); ?></span></small><hr>
		<h3>Sueldo neto: <span class="total"><?php echo money_format('%i', $nom_tot); ?></span></h3>
		</div>
</div>
<?php require_once("../includes/footer.php"); ?>