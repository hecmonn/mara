<?php
require_once("../includes/php_init.php");
$sql_rs="SELECT id,razon FROM razones_sociales";
$res_rs=exec_query($sql_rs);
if(isset($_POST["submit"])){
	$id=$_POST["rs"];
	$marca = mysql_prep($_POST["marca"]);
	$plaza = mysql_prep($_POST["plaza"]);
	$correo = mysql_prep($_POST["correo"]);
	$dir1 = mysql_prep($_POST["direccion"]);
	$dir2 = mysql_prep($_POST["direccion1"]);
	$dir_com = $dir1 . " " . $dir2;
	$cd = mysql_prep($_POST["ciudad"]);
	$tel = mysql_prep($_POST["telefono"]);
	$sql_ins = "INSERT INTO sucursales(marca,plaza,domicilio,telefono,correo,ciudad,id_rs) VALUES";
	$sql_ins.="('{$marca}','{$plaza}','{$dir_com}','{$tel}','{$correo}','{$cd}','{$id}')";
	$res_ins = exec_query($sql_ins);
	if($res_ins){
		$_SESSION["message"]="Sucursal creada exitosamente.";
		redirect_to("sucursales.php");
	}
}
$title="Nueva sucursal";
require_once("../includes/header.php");
?>
<a href="sucursales.php">&laquo;Regresar</a><br><br>
<form action="nueva_sucursal.php" method="post">
	<div class="col-md-3">
		<label for="marca">Marca</label><br>
		<select name="marca" class="form-control">
			<option>-</option>
			<option>Tenis Show</option>
			<option>Kenneth Cole</option>
			<option>Benissimo</option>
			<option>The Body Shop</option>
			<option>Lacoste</option>
			<option>MARA</option>
		</select><br>
		<label for="rs">Razón social</label>
		<select name="rs" class="form-control">
			<option>-</option>
			<?php 
			while($row=fetch($res_rs)){
				$option= "<option value=\"".$row[ "id"]."\">".$row["razon"]."</option>";
				echo $option;
			}?>
		</select><br>
		<label for="plaza">Sucursal</label><br>
		<select name="plaza" class="form-control">
			<option>-</option>
			<option>San Isidro</option>
			<option>Walmart 68</option>
			<option>Forum</option>
			<option>Galerias San Miguel</option>
			<option>Plaza Fiesta</option>
			<option>Puerto Paraiso</option>
			<option>Las Plazas Outlet</option>
			<option>Outlet Mulza</option>
			<option>Oficina</option>
		</select><br>
		<label for="correo">Correo</label><br>
		<input type="email" name="correo" class="form-control">
	</div>
	<div class="col-md-5">
		<label for="direccion">Dirección</label><br>
		<input type="text" name="direccion" class="form-control">
		<input type="text" name="direccion1" class="form-control"><br>
		<label for="ciudad">Ciudad</label><br>
		<select name="ciudad" class="form-control">
			<option>-</option>
			<option>Culiacán</option>
			<option>Guadalajara</option>
			<option>León</option>
			<option>Cabo San Lucas</option>
		</select><br>
		<label for="telefono">Telefono</label><br>
		<input type="text" name="telefono" class="form-control"><br>
		<input type="submit" name="submit" value="Crear" class="btn btn-success pull-right">
	</div>
	<div class="col-md-4"></div>
</form>
<?php require_once("../includes/footer.php"); ?>