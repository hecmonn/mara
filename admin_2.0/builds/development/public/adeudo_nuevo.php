<?php 
require_once("../includes/php_init.php");
$sql_em="SELECT * FROM empleados";
$res_em=exec_query($sql_em);

if(isset($_POST["submit"])){
	$id_e=mysql_prep($_POST["id_e"]);
	$descr=mysql_prep($_POST["descr"]);
	$type=mysql_prep($_POST["type"]);
	$cant=mysql_prep($_POST["cant"]);
	exec_query("begin");
	$sql_ad="INSERT INTO adeudos(descr,cantidad,tipo,id_em) VALUES";
	$sql_ad.="('{$descr}','{$cant}','{$type}','{$id_e}')";
	$res_ad=exec_query($sql_ad);
	$id_last_rec=mysqli_insert_id($Database->con);
	$sql_ad_rec="INSERT INTO adeudos_records(cantidad,id_ad) VALUES('{$cant}','{$id_last_rec}')";
	$res_ad_rec=exec_query($sql_ad_rec);
	if($res_ad && $res_ad_rec){
		exec_query("commit");
		$_SESSION["message"]="Adeudo agregado";
		redirect_to("adeudos.php");
	}
	else{exec_query("rollback");}
}
$title="Nuevo adeudo";
require_once("../includes/header.php");
?>
	<form action="adeudo_nuevo.php" method="post">
		<div class="row">
			<div class="col-md-6">
				<label for="name">Empleado</label>
				<select name="id_e" class="form-control">
					<?php while($row=fetch($res_em)){
						$id=$row["id"];
						$nom=$row["nombre"];
						echo "<option value={$id}>{$nom}</option>";
						} ?>
				</select><br>
				<label for="descr">Descripción</label>
				<textarea name="descr" class="form-control"></textarea>
			    
			</div>
			<div class="col-md-6">
				<label for="type">Tipo de adeudo</label>
				<select name="type" class="form-control">
					<option>Uniforme</option>
					<option>Prestamo</option>
					<option>Crédito</option>
				</select><br>
				<label for="cant">Cantidad</label>
			    <div class="input-group">
			    	<div class="input-group-addon">$</div>
			    	<input type="number" name="cant" class="form-control">
				</div><br>
			    	<input type="submit" name="submit" class="btn btn-success pull-right">
			</div>
		</div>
	</form>
<?php require_once("../includes/footer.php"); ?>