<?php
require_once("../includes/php_init.php");
require_once("../includes/Pagination.php");
$page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
$per_page = 10;
$total_count =count_rec("proveedores");
$Pagination = new Pagination($page, $per_page, $total_count);
$sql_prov="SELECT * FROM proveedores";
$res_prov=exec_query($sql_prov);
$proveedores="";
while ($row=fetch($res_prov)) {
    $nombre=$row["nombre"];
    $persona=$row["persona"];
    $ciudad=$row["ciudad"];
    $rfc=$row["rfc"];
    $id=$row["id"];
    $proveedores.="<tr><td><a href='proveedor_ver?c={$id}'>{$nombre}</a></td>";
    $proveedores.="<td>{$persona}</td>";
    $proveedores.="<td>{$ciudad}</td>";
    $proveedores.="<td>{$rfc}</td></tr>";
}
$title="Proveedores";
require_once("../includes/header.php");
?>
<div class="container">
    <a href="proveedor_crear" class="btn btn-md btn-default pull-right">Añadir</a><br><br>
    <table class="table table-striped">
        <tr>
            <th>Nombre</th>
            <th>Persona</th>
            <th>Ciudad</th>
            <th>RFC</th>
        </tr>
        <?php echo $proveedores; ?>
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
</div>

<?php require_once("../includes/footer.php"); ?>
