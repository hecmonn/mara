<?php
require_once("../includes/php_init.php");
require_once("../includes/Photograph.php");

if(isset($_POST["submit"])){
	$nombre = mysql_prep($_POST["nombre"]);
	$dob = mysql_prep($_POST["dob"]);
	$tel = mysql_prep($_POST["tel"]);
	$sex = mysql_prep($_POST["sex"]);
	$dir = mysql_prep($_POST["dir"]);
	$dir1 = mysql_prep($_POST["dir1"]);
	$dir_com = $dir." ".$dir1;
	$curp = mysql_prep($_POST["curp"]);
	$puesto = mysql_prep($_POST["puesto"]);
	$imss=mysql_prep($_POST["imss"]);
	$inf=mysql_prep($_POST["inf"]);
	$sueldo = mysql_prep($_POST["sueldo"]);
	$no_imss = mysql_prep($_POST["no_imss"]);
	$rfc = mysql_prep($_POST["rfc"]);
	$id_suc=$_POST["suc"];
	exec_query("begin");
	$sql_em="INSERT INTO empleados(nombre,telefono,curp,imss,f_nam,sexo,puesto,sueldo,direccion,infonavit,id_suc,no_imss,rfc)";
	$sql_em.=" VALUES('{$nombre}','{$tel}','{$curp}','{$imss}','{$dob}','{$sex}','{$puesto}',";
	$sql_em.="'{$sueldo}','{$dir_com}','{$inf}','{$id_suc}','{$no_imss}','{$rfc}')";
	$res_em=exec_query($sql_em);
	$id_e=mysqli_insert_id($Database->con);
	if($res_em){
		$file=$_FILES["photo"];
		$Photograph->attach_file($file);
		$photo_name = $Photograph->save_photo($id_e);
		$sql_up="UPDATE empleados SET photo_path='".$photo_name."' WHERE id={$id_e}";
		$res_up=exec_query($sql_up);
		if(!$photo_name){
			$_SESSION["message"]="Intentar de nuevo";
			redirect_to("nuevo_empleado.php");
		}
		exec_query("commit");
		$_SESSION["message"]="Empleado creado exitosamente";
		redirect_to("empleados.php");
	}
	else{
		exec_query("rollback");
		$_SESSION["message"]="Ingresar datos nuevamente";
	}
}
$title="Nuevo empleado";
require_once("../includes/header.php");
?>
<form action="nuevo_empleado.php" method="post" enctype="multipart/form-data">
	<div class="col-md-4">
		<label for="nombre">Nombre</label><br>
		<input type="text" name="nombre" class="form-control" required><br>
		<label for="dob">Fecha de nacimiento</label><br>
		<input type="date" name="dob" class="form-control" required><br>
		<label for="tel">Telefono</label><br>
		<input type="text" name="tel" class="form-control" required><br>
		<label for="dir">Dirección</label><br>
		<input type="text" name="dir" class="form-control" required>
		<input type="text" name="dir1" class="form-control"><br>
		<label for="sex">Sexo</label>
		<div class="col-md-12">
			<div class="col-md-6"><input type="radio" name="sex" value="m" checked="checked" class="form-control">M</div>
			<div class="col-md-6"><input type="radio" name="sex" value="f" class="form-control">F</div>
		</div>
	</div>
	<div class="col-md-4">
		<label for="imss">Infonavit</label><br>
		<div class="input-group">
			<div class="input-group-addon">$</div>
		<input type="text" name="inf" class="form-control">
		</div><br>
		<label for="imss">IMSS</label><br>
		<div class="input-group">
			<div class="input-group-addon">$</div>
		<input type="text" name="imss" class="form-control">
		</div>
		<div class="input-group">
			<div class="input-group-addon">#</div>
		<input type="text" name="no_imss" class="form-control" required>
		</div><br>
		<label for="curp">CURP</label><br>
		<div class="input-group">
			<div class="input-group-addon">#</div>
		<input type="text" name="curp" class="form-control">
		</div><br>
		<label for="rfc">RFC</label><br>
		<div class="input-group">
			<div class="input-group-addon">#</div>
		<input type="text" name="rfc" class="form-control">
		</div><br>
	</div>
	<div class="col-md-4">
		<label for="puesto">Puesto</label>
		<select name="puesto" class="form-control" required>
			<option selected disabled>Escoger una opción</option>
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
			<option>Coordinador de operaciones</option>
		</select><br>
		<label for="suc">Sucursal</label>
		<select name="suc" class="form-control">
			<option selected disabled>Escoger una opción</option>
	<?php
		$sql_suc="SELECT * FROM sucursales";
		$res_suc=exec_query($sql_suc);
		while($row=fetch($res_suc)){
			$id=$row["id"];
			$tienda=utf8_encode($row["marca"])." ".utf8_encode($row["plaza"])." ".utf8_encode($row["ciudad"]);
			echo "<option value=\"$id\">".$tienda."</option>";
		}
	 ?>
	 	</select><br>
		<label for="sueldo">Sueldo quincenal</label><br>
		<div class="input-group">
			<div class="input-group-addon">$</div>
			<input type="number" name="sueldo" class="form-control"><br>
		</div><br>
		<label for="photo">Foto</label>
		<input type="file" name="photo" class="form-control" required><br>
		<input type="submit" name="submit" value="Crear" class="btn btn-default pull-right">
	</div>
</form>
<?php require_once("../includes/footer.php"); ?>
