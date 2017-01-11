<?php
require_once("../includes/php_init.php");
$q=$_GET["s"];
$fortnight= quincena();
$curr=$fortnight[0];
$sql_em="SELECT * FROM empleados e WHERE e.id_suc={$q} AND e.estado=1 AND id NOT IN(SELECT id_em FROM nomina_em WHERE quin='{$curr}')";
$res_em=exec_query($sql_em);
if(isset($_POST["submit"])){
	$com=mysql_prep($_POST["com"]);
	$fal=mysql_prep($_POST["fal"]);
	$des=mysql_prep($_POST["des"]);
	$come=mysql_prep($_POST["come"]);
	$date_tod=date("Y-M-d", time());
	$id_e=$_POST["id_e"];
	$sql_nom="INSERT INTO nomina_em(descansos,faltas,comisiones_en,quin,comentarios,id_em)";
	$sql_nom.=" VALUES('{$des}','{$fal}','{$com}','{$curr}','{$come}','{$id_e}')";
	$res_nom=exec_query($sql_nom);
	if($res_nom){
		$_SESSION["message"]="¡Quincena capturada exitosamente!";
		redirect_to("em_nom.php?s=$q");
	}
}
$days_ago=date("d F", strtotime($fortnight[1]));
$days_fort=date("d F", strtotime($curr));
$title="Nomina";
require_once("../includes/header.php");
?>
<div class="nom-header">
	<p class="text-center">
		Estás capturando para la quincena del <strong><?php echo $days_ago; ?></strong>	 al <strong><?php echo $days_fort; ?></strong>
	</p>
</div>
<div class="col-md-4 col-md-offset-4">
	<form action="em_nom.php?s=<?php echo $q; ?>" method="post">
		<label for="name">Empleado</label>
		<select name="id_e" class="form-control">
			<?php while($row=fetch($res_em)){
				$id=$row["id"];
				$nom=$row["nombre"];
				echo "<option value={$id}>{$nom}</option>";
				} ?>
		</select><br>
		<label for="des">Descansos</label>
		<input type="number" name="des" class="form-control">
		<small class="text-muted">Añadir el número de descansos trabajados</small><br><br>
		<label for="fal">Faltas</label>
		<input type="number" name="fal" class="form-control">
		<small class="text-muted">Añadir el número de faltas en la quincena</small><br><br>
		<label for="com">Comisiones</label>
		<input type="number" name="com" min="0.1" step="0.1" class="form-control" required><br>
		<label for="come">Comentarios</label>
		<textarea col="5" rows="3" name="come" class="form-control"></textarea><br>
		<input type="submit" name="submit" value="Capturar" class="btn btn-default pull-right">
	</form>
</div>
<?php require_once("../includes/footer.php"); ?>
