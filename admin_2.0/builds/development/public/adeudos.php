<?php
require_once("../includes/php_init.php");
$sql_ad="SELECT a.id_em,e.nombre,sum(a.cantidad) cant_tot,a.created_date,a.descr";
$sql_ad.=" FROM empleados e, adeudos a WHERE e.id=a.id_em GROUP BY e.nombre ORDER BY cant_tot DESC";
$res_ad=exec_query($sql_ad);
$title="Adeudos";
require_once("../includes/header.php");
?>
<a href="adeudo_nuevo.php" class="btn btn-default pull-right">Añadir adeudo</a><br><br>
<table class="table table-striped">
	<tr>
		<th>Nombre</th>
		<th>Descripción</th>
		<th>Cantidad</th>
		<th>Opciones</th>
	</tr>
	<?php 
	$output="";
	while($row=fetch($res_ad)){
		$id=$row["id_em"];
		$output.="<tr><td>".html_prep($row["nombre"])."</td>";
		$output.="<td>".html_prep($row["descr"])."</td>";
		$output.="<td>$".money_format('%i', $row["cant_tot"])."</td>";
		$output.="<td><a href=\"ver_ad_em.php?e={$id}\">VER</a></td></tr>";
		} 
		echo $output;?>
</table>
<?php require_once("../includes/footer.php"); ?>