<?php 
require_once("../includes/php_init.php");
require_once("../includes/Empleados.php");
$id_e=$_GET["e"]; 
//$m=get_quincena("2016-07-30 12:12:12");
$sql_e="SELECT e.nombre,e.telefono,e.estado";
$sql_e.=",e.direccion,e.photo_path,s.marca,s.plaza,s.ciudad";
$sql_e.=",rs.razon FROM empleados e, sucursales s, razones_sociales rs";
$sql_e.=" WHERE e.id={$id_e} AND e.id_suc=s.id AND s.id_rs=rs.id";
$res_e=exec_query($sql_e);
while($row=fetch($res_e)){
	$photo_path=$row["photo_path"];
	$nom=html_prep($row["nombre"]);
	$direccion=html_prep($row["direccion"]);
	$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
}
$title="Adeudos";
require_once("../includes/header.php");
?>
<div class="row">
	<div class="col-md-2">
		<a href="adeudos.php">&laquo;Regresar</a>
		<img src="<?php echo $photo_path; ?>" width="120" height="180">
	</div>
	<div class="col-md-10"><br>
		<h3><strong><?php echo "Nombre: </strong>".$nom; ?></h3>
		<h3><strong><?php echo "Dirección: </strong>".$direccion; ?></h3>
		<h3><strong><?php echo "Tienda: </strong>".$tienda; ?></h3>
	</div>
</div><br>
<h4>Adeudos</h4>
<div class="col-md-12">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-striped">
				<tr>
					<th>Descripción</th>
					<th>Cantidad</th>
					<th>Fecha</th>
				</tr>
			<?php 
				$table_ad=$Empleados->show_adeudos($id_e);
				echo $table_ad;
			?>
			</table>
		</div>
		<div class="col-md-6">
			<div id="abonos"></div>
		</div>
	</div>
</div>
<?php require_once("../includes/footer.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	function showAbonos(id){
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
			} else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
		    	document.getElementById("abonos").innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","get_abonos_ajax.php?i="+id,true);
		xmlhttp.send();
	}
	$(document).ready(function(){
		$('a').click(function(){
			var id=$(this).attr('id');
			showAbonos(id);
		})
	});
</script>