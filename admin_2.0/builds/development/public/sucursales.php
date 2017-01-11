<?php
require_once("../includes/php_init.php");
require_once("../includes/Pagination.php");
$page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
$per_page = 10;
$total_count =count_rec("sucursales");
$Pagination = new Pagination($page, $per_page, $total_count);
$sql_suc="SELECT s.id,s.ciudad,s.marca,s.plaza,rs.razon FROM sucursales s, razones_sociales rs";
$sql_suc.=" WHERE rs.id = s.id_rs ORDER BY s.id";
$sql_suc.=" LIMIT " . $Pagination->per_page . " OFFSET " . $Pagination->offset();
$res_suc=exec_query($sql_suc);
$title="Sucursales";
require_once("../includes/header.php");
?>
<a href="nueva_sucursal.php" class="btn btn-default pull-right">Añadir sucursal</a><br>
<br>
<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Marca</th>
		<th>Plaza</th>
		<th>Ciudad</th>
		<th>Razón Social</th>
		<th>Opciones</th>
	</tr>
<?php
	$table="";
	while($row=fetch($res_suc)){
		$cd = utf8_encode($row["ciudad"]);
		$id=$row["id"];
		$output="<tr><td>".$row["id"]."</td>";
		$output.="<td>".$row["marca"]."</td>";
		$output.="<td>".$row["plaza"]."</td>";
		$output.="<td>".$cd."</td>";
		$output.="<td>".$row["razon"]."</td>";
		$output.="<td><a href=\"ver_sucursal.php?s=$id\">VER</a></td></tr>";
		$table .= $output;
	}
	echo $table;
 ?>
 	</tr>
</table>
<div class="pagination pull-right">
<?php
	if($Pagination->total_pages() > 1){
		if($Pagination->has_prev_page()){
			echo "<a href=\"sucursales.php?page=";
			echo $Pagination->prev_page();
			echo "\">&laquo; Previous</a>";
		}
		for ($i=1; $i <= $Pagination->total_pages(); $i++){
			if($i==$page){
				echo "<span class=\"selected\">{$i}</span>";
			}
			else{
				echo "<a href=\"sucursales.php?page={$i}\"> {$i} </a>";
			}
		}
		if($Pagination->has_next_page()){
			echo "<a href=\"sucursales.php?page=";
			echo $Pagination->next_page();
			echo "\">Next &raquo; </a>";
		}
	}
?>
</div>
<?php require_once("../includes/footer.php"); ?>
