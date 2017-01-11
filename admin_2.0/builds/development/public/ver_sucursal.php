<?php
require_once("../includes/php_init.php");
$id_s=$_GET["s"];
$sql_s="SELECT s.marca,s.ciudad,s.domicilio,s.telefono,s.correo,s.plaza,rs.razon";
$sql_s.=" FROM sucursales s, razones_sociales rs WHERE rs.id=s.id_rs AND s.id={$id_s}";
$res_s=exec_query($sql_s);
while ($row=fetch($res_s)) {
	$marca=html_prep($row["marca"]);
	$domicilio=html_prep($row["domicilio"]);
	$telefono=html_prep($row["telefono"]);
	$correo=htmlentities($row["correo"]);
	$plaza=html_prep($row["plaza"]);
	$ciudad=html_prep($row["ciudad"]);
	$rs=html_prep($row["razon"]);
}
$title="Sucursales";
require_once("../includes/header.php");
?>
<div class="col-md-4">
	<strong><a href="sucursales.php">&laquo;Regresar</a></strong>	
	<h3><strong><?php echo "Marca: </strong>".$marca ?></h3>
	<h3><strong><?php echo "Plaza: </strong>".$plaza ?></h3>
	<h3><strong><?php echo "Ciudad: </strong>".$ciudad ?></h3>
	<h3><strong><?php echo "Correo: </strong>".$correo ?></h3>
</div>
<div class="col-md-8">
<br>
	<h3><strong><?php echo "Razón social: </strong>".$rs ?></h3>
	<h3><strong><?php echo "Domicilio: </strong>".$domicilio ?></h3>
	<h3><strong><?php echo "Telefono: </strong>".$telefono ?></h3>
</div>
<?php require_once("../includes/footer.php"); ?>