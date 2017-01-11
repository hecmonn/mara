<?php
require_once("../includes/php_init.php");
require_once("../includes/Empleados.php");
$id_e=$_GET["e"];
$sql_e="SELECT e.nombre,e.puesto,e.sueldo,e.imss,e.infonavit,";
$sql_e.="s.marca,s.plaza,s.ciudad";
$sql_e.=",rs.razon FROM empleados e, sucursales s, razones_sociales rs";
$sql_e.=" WHERE e.id={$id_e} AND e.id_suc=s.id AND s.id_rs=rs.id";
$res_e=exec_query($sql_e);
while ($row=fetch($res_e)) {
	$nom=html_prep($row["nombre"]);
	$infonavit=(float)($row["infonavit"]);
	$imss=(float)($row["imss"]);
	$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
	$rs=$row["razon"];
	$sb=(float)$row["sueldo"];
	$sd=$sb/15;
	$nom=html_prep($row["nombre"]);
}
//set holidays

//months with 31 days
$fortnight= quincena($sd);
$fecha=$fortnight[0];
$days_ago=$fortnight[1];
$sb=$fortnight[2];

//get data from empleados(nom_em.php)
$fal=0;
$des=0;
$com=0;
$curr_quin=date("Y-M-d",time());
$quin=quincena($curr_quin);
$sql_pem="SELECT * FROM nomina_em WHERE id_em={$id_e} AND quin BETWEEN '{$days_ago} 00:00:00' AND '{$fecha} 23:59:59'";
$res_pem=exec_query($sql_pem);
while ($row=fetch($res_pem)) {
	$fal=(int)($row["faltas"]);
	$des=(int)($row["descansos"]);
	$com=html_prep($row["comisiones_en"]);
	$comentarios=html_prep($row["comentarios"]);
}
//fetch comisiones --conexion mssql bd

//on submit
if(isset($_POST["submit"])){
	$faltas=mysql_prep($_POST["fal"]);
	$descansos=mysql_prep($_POST["des"]);
	$com=mysql_prep($_POST["com"]);
	$ca=mysql_prep($_POST["ca"]);
	$cf=mysql_prep($_POST["cf"]);
	$ab_count=count($_POST["abono"]);
	$fal_eco = $sd * $faltas;
	$des_eco = $sd * $descansos; //clarificar descansos
	$abono_tot=0;
	for($i=0;$i<$ab_count;$i++){
		$abono=(float)$_POST["abono"][$i];
		$id_ad=(int)$_POST["id"][$i];
		$cant=(float)$_POST["cant"][$i];
		$upd_cant=$cant-$abono;
		$sql_ab="INSERT INTO abonos(cantidad,id_ad) VALUES ('{$abono}','{$id_ad}')";
		$res_ab=exec_query($sql_ab);
		$sql_up_ad="UPDATE adeudos SET cantidad={$upd_cant} WHERE id={$id_ad}";
		$res_up_ad=exec_query($sql_up_ad);
		$abono_tot=$abono_tot+$abono;
	}
	$sf=$sb-$infonavit;
	$nom_tot=(float)$sf+(float)$des_eco+(float)$com-(float)$fal_eco-(float)$cf-(float)$ca-(float)$abono_tot;
	$sql_nom="INSERT INTO nomina(sueldo,comisiones,descanso,faltas,credifam,caja_ahorro,abono,quin,nom_tot,sueldo_base,id_em)";
	$sql_nom.=" VALUES('{$sf}','{$com}','{$descansos}','{$faltas}','{$cf}','{$ca}','{$abono_tot}','{$fecha}','{$nom_tot}','{$sb}','{$id_e}')";
	$res_nom=exec_query($sql_nom);
	if($res_nom){
		$_SESSION["message"]="Nomina de {$nom} capturada";
		redirect_to("ver_nom_em.php?e=$id_e");
	}
}
$title="Nomina ";
require_once("../includes/header.php");
?>

<div class="row">
	<div class="col-md-5">
		<a href="nomina.php">&laquo;Regresar</a>
		<h4><strong><?php echo "Nombre: </strong>".$nom; ?></h4>
		<h4><strong><?php echo "Razón Social: </strong>".$rs; ?></h4>
		<h4><strong><?php echo "Tienda: </strong>".$tienda; ?></h4>
	</div>
	<div class="col-md-3">

	</div>
	<div class="col-md-4">
		<h4>Quincena de <?php echo $days_ago." Al ".$fecha ?></h4>
	</div>
</div><br>
	<div class="row">
		<div class="col-md-3">
			<form action="crear_nom_em.php?e=<?php echo $id_e; ?>" method="post">
				<label for="sueldo">Sueldo base</label>
				<div class="input-group">
			    	<div class="input-group-addon">$</div>
			    	<input type="number" name="cant" value="<?php echo number_format($sb, 2, '.', ''); ?>" class="form-control" disabled>
				</div><br>
				<label for="com">Comisiones</label>
				<div class="input-group">
			    	<div class="input-group-addon">$</div>
			    	<input type="number" name="com" min="0.1" step=".01" value="<?php echo "0"; ?>" class="form-control">
				</div>
			    <small>Según sistema:</small><br>
			    <small>Según empleados: <?php echo money_format('%i', $com); ?></small><br>
		</div>

		<div class="col-md-3">
			<label for="cf">CrediFam</label>
			<div class="input-group">
			    <div class="input-group-addon">$</div>
			    <input type="number" min="0.01" step=".01" name="cf" class="form-control">
			</div><br>
			<label for="ca">Caja Ahorro</label><br>
			<div class="input-group">
			    <div class="input-group-addon">$</div>
			    <input type="number" min="0.1" step=".01" name="ca" class="form-control">
			</div><br>
		</div>
		<div class="col-md-3">
			<label>Faltas</label>
			<input type="number" step="1" min="0" name="fal" class="form-control">
			<small>Faltas segun empleado: <?php echo $fal ?></small><br>
			<label>Descansos</label>
			<input type="number" step="1" min="0" name="des" class="form-control">
			<small>Descansos segun empleado: <?php echo $des ?></small>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<label>Abonos a adeudos</label>
					<table class="table table-striped">
					<?php
					$output="";
					$sql_a="SELECT * FROM adeudos WHERE id_em={$id_e} AND cantidad>0";
					$res_a=exec_query($sql_a);
					while($row=fetch($res_a)){
						$id=$row["id"];
						$cant=$row["cantidad"];
						$output.="<input type=\"hidden\" name=\"id[]\" value=\"$id\">";
						$output.="<input type=\"hidden\" name=\"cant[]\" value=\"$cant\">";
						$output.="<tr><td>".html_prep($row["descr"])."</td>";
						$output.="<td>".money_format('%i', $row["cantidad"])."</td>";
						$output.="<td><input type=\"text\" min=\"0.1\" step=\".01\" name=\"abono[]\" class=\"form-control\"></td></tr>";
					}
				echo $output;
					?>
					</table>
				</div>
				<div class="col-md-6">
					<label>Comentarios</label>
					<textarea cols="5" rows="3" class="form-control" disabled><?php if(isset($comentarios)) echo $comentarios; ?></textarea><br>
					<input type="submit" value="Generar" 	name="submit" class="btn btn-success pull-right">
				</div>
			</div>
			</form>
			</div>
		</div>
<?php require_once("../includes/footer.php"); ?>
