<?php
require_once("../includes/php_init.php");
if($_SESSION["role"] == 2){
	$_SESSION["message"]="No cuentas con acceso a este sitio.";
	redirect_to("index.php");
}
$fortnight= quincena();
$fecha=$fortnight[0];
$sql_em = "select e.id,e.nombre,s.marca,s.plaza,s.ciudad from empleados e, sucursales s where e.id_suc = s.id";
$sql_em.=" AND e.estado=1 AND e.id not in (select id_em from nomina where quin='{$fecha}') ORDER BY e.id";
$res_em = exec_query($sql_em);
$title="Nomina";
require_once("../includes/header.php");
?>
<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Nombre</th>
		<th>Sucursal</th>
		<th>Opciones</th>
	</tr>
<?php
	$table="";
	while ($row=fetch($res_em)) {
		$id_e=$row["id"];
		$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
		$output="<tr><td>".$id_e."</td>";
		$output.="<td>".$row["nombre"]."</td>";
		$output.="<td>".$tienda."</td>";
		$output.="<td><a href=\"crear_nom_em.php?e=$id_e\">Generar</a></td></tr>";
		$table.=$output;
	}
	echo $table;
?>
</table><br>
<?php require_once("../includes/footer.php"); ?>
