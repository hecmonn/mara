<?php
require_once("../includes/php_init.php");
$e=$_GET["e"];
$sql_em="SELECT * FROM empleados WHERE id={$e}";
$res_em=exec_query($sql_em);
while ($row=fetch($res_em)) {
	$photo=$row["photo_path"];
	$nom=html_prep($row["nombre"]);
	$curp=html_prep($row["curp"]);
	$dir=html_prep($row["direccion"]);
	$sb=html_prep($row["sueldo"]);
	$id_suc=$row["id_suc"];
	$fing=date("jS M, y", strtotime($row["f_ing"]));
	$pst=html_prep($row["puesto"]);
	$st=$row["estado"];
}
$estado=$st?"ACTIVO":"BAJA";
$rad_st=$st?"<input type=\"radio\" name=\"est\" value=\"1\" checked=\"checked\" disabled> ACTIVO<br><input type=\"radio\" name=\"est\" value=\"0\"> BAJA":"<input type=\"radio\" name=\"est\" value=\"1\"> ACTIVO<br><input type=\"radio\" name=\"est\" value=\"0\" checked=\"checked\" disabled> BAJA";

if(isset($_POST["submit"])){
	$sueldo=isset($_POST["sueldo"])?mysql_prep($_POST["sueldo"]):$sb;
	$puesto=isset($_POST["puesto"])?mysql_prep($_POST["puesto"]):$pst;
	$suc=isset($_POST["suc"])?mysql_prep($_POST["suc"]):$id_suc;
	$est=isset($_POST["est"])?mysql_prep($_POST["est"]):$st;
	exec_query("begin");
	$sql_up="UPDATE empleados SET sueldo={$sueldo}, id_suc={$suc}, puesto='{$puesto}', estado={$est} WHERE id={$e}";
	$res_up=exec_query($sql_up);
	if($res_up){
		exec_query("commit");
		$_SESSION["messsage"]="{$nom} actualizado exitosamente";
		redirect_to("ver_empleado.php?e=$e");
	}
	else{
		exec_query("rollback");
		$_SESSION["message"]="Porfavor intente de nuevo";
		redirect_to("editar_em.php?e=$e");
	}
}
$title="Editar empleado";
require_once("../includes/header.php");
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
			<img src="<?php echo $photo; ?>" height="180" width="120">
		</div>
		<div class="col-md-3">
			<label for="nom">Nombre</label>
			<input type="text" name="nom" value="<?php echo $nom; ?>" class="form-control" disabled><br>
			<label for="curp">CURP</label>
			<input type="text" name="curp" class="form-control" value="<?php echo $curp; ?>" disabled><br>
		</div>
		<div class="col-md-3">
			<label for="dir">Direccion</label>
			<input type="text" name="dir" value="<?php echo $dir; ?>" class="form-control" disabled><br>
			<label>Fecha de ingreso: </label><?php echo $fing; ?>
		</div>
		<div class="col-md-3 pull-right">
			<label for="dir">Estado</label>
			<h3><?php echo $estado; ?></h3><br>
		</div>
		
	</div><hr>
	<div class="row">
		<form action="editar_em.php?e=<?php echo $e; ?>" method="post">
			<div class="col-md-3">
				<label for="fing">Estado</label><br>
				<?php echo $rad_st; ?>
			</div>
			<div class="col-md-4">
				<label for="puesto">Puesto</label>
				<select name="puesto" class="form-control">
					<option selected disabled>Escoger puesto</option>
					<option>RH</option>
					<option>Mantenimiento</option>
					<option>Informatica</option>
					<option>Auxiliar de almacen</option>
					<option>Almacen</option>
					<option>Credito</option>
					<option>Auxiliar administrativo</option>
					<option>Contabilidad</option>
					<option>Guardia</option>
					<option>Asesor</option>
					<option>Sublider</option>
					<option>Lider</option>
				</select><br>
				<label for="sueldo">Sueldo</label>
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" name="sueldo" class="form-control" value="<?php echo $sb;?>">
				</div><br>
			</div>
			<div class="col-md-4">
				<label for="suc">Sucursal</label>
				<select name="suc" class="form-control">
					<option selected disabled>Escoger sucursal</option>
					<?php 
					$sql_suc="SELECT * FROM sucursales";
					$res_suc=exec_query($sql_suc);
					while($row=fetch($res_suc)){
						$id=$row["id"];
						$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
						echo "<option value=\"$id\">".$tienda."</option>";
					}
				 ?>
				</select><br>
				<input type="submit" name="submit" value="Editar" class="btn btn-success pull-right">
			</div>

		</form>
	</div>
</div>
<?php require_once("../includes/footer.php"); ?>