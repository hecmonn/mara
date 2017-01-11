<?php
require_once("../includes/php_init.php");
require_once("../includes/Empleados.php");
require_once("../includes/Pagination.php"); 
$page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
$per_page = 10;
//$total_count = count_rec("empleados");
$sql_count_em="SELECT count(*) FROM empleados WHERE estado=1";
$res_count_em=exec_query($sql_count_em);
$total_count=array_shift(fetch($res_count_em));
$Pagination = new Pagination($page, $per_page, $total_count);
$sql_em = "select e.id,e.nombre,s.marca,s.plaza,s.ciudad from empleados e, sucursales s where e.id_suc = s.id and e.estado=1 ORDER BY s.id";
$sql_em.= " LIMIT " . $Pagination->per_page . " OFFSET " . $Pagination->offset();
$res_em = exec_query($sql_em);
$title="Empleados";
require_once("../includes/header.php");
?>
<a href="nuevo_empleado.php" class="btn btn-md btn-default pull-right">Añadir empleado</a><br><br>
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
		$output.="<td><a href=\"ver_empleado.php?e=$id_e\">VER</a></td>";
		$table.=$output;
	}
	echo $table;
 ?>
</table>
<div class="pagination pull-right">
<?php
	if($Pagination->total_pages() > 1){
		if($Pagination->has_prev_page()){
			echo "<a href=\"empleados.php?page=";
			echo $Pagination->prev_page();
			echo "\">&laquo; Previous</a>";
		}
		for ($i=1; $i <= $Pagination->total_pages(); $i++){
			if($i==$page){
				echo "<span class=\"selected\">{$i}</span>";
			}
			else{
				echo "<a href=\"empleados.php?page={$i}\"> {$i} </a>";
			}
		}
		if($Pagination->has_next_page()){
			echo "<a href=\"empleados.php?page=";
			echo $Pagination->next_page();
			echo "\">Next &raquo; </a>";
		}
	}
?>
</div>
<?php require_once("../includes/footer.php"); ?>