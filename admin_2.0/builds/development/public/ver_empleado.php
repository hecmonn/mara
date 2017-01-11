<?php
require_once("../includes/php_init.php");
$id_e=$_GET["e"];
$sql_e="SELECT e.nombre,e.telefono,e.curp,e.imss,e.sexo";
$sql_e.=",e.f_nam,e.f_ing,e.f_sal,e.estado,e.puesto,e.sueldo";
$sql_e.=",e.direccion,e.photo_path,e.no_imss,s.marca,s.plaza,s.ciudad";
$sql_e.=",rs.razon FROM empleados e, sucursales s, razones_sociales rs";
$sql_e.=" WHERE e.id={$id_e} AND e.id_suc=s.id AND s.id_rs=rs.id";
$res_e=exec_query($sql_e);
while ($row=fetch($res_e)){
	//empleado
	$nom=html_prep($row["nombre"]);
	$tel=html_prep($row["telefono"]);
	$curp=html_prep($row["curp"]);
	$imss=html_prep($row["imss"]);
	$no_imss=html_prep($row["no_imss"]);
	$sexo=html_prep($row["sexo"]);
	$f_nam=date("jS F, Y", strtotime($row["f_nam"]));
	$f_ing=date("jS F, Y", strtotime($row["f_ing"]));
	$f_sal=!empty($row["f_sal"])?date("jS F, Y", strtotime($row["f_sal"])):"NUNCA";
	$estado=$row["estado"]? "ACTIVO":"BAJA";
	$puesto=html_prep($row["puesto"]);
	$sueldo=money_format('$%i',$row["sueldo"]);
	$direccion=html_prep($row["direccion"]);
	$photo_path=$row["photo_path"];
	//sucursal
	$marca=html_prep($row["marca"]);
	$plaza=html_prep($row["plaza"]);
	$ciudad=html_prep($row["ciudad"]);
	$tienda = $marca." ".$plaza." ".$ciudad;
	//razon social
	$rs_nom=html_prep($row["razon"]);
}
$title="Ver empleado";
require_once("../includes/header.php");
?>
<div class="row">
	<a href="editar_em.php?e=<?php echo $id_e; ?>" class=" btn btn-default pull-right">Editar empleado</a>
	<div class="col-md-2">
		<a href="empleados.php">&laquo;Regresar</a>
		<img src="<?php echo $photo_path; ?>" width="120" height="180">
	</div>
	<div class="col-md-4"><br>
		<h4><strong><?php echo "Nombre: </strong><span class=\"view_detail\">".$nom; ?></span></h4>
		<h4><strong><?php echo "Sexo: </strong><span class=\"view_detail\">".$sexo; ?></span></h4>
		<h4><strong><?php echo "Tienda: </strong><span class=\"view_detail\">".$tienda; ?></span></h4>
	</div>
	<div class="col-md-5"><br>
		<h4><strong><?php echo "Estado: </strong><span class=\"view_detail\">".$estado; ?></span></h4>
		<h4><strong><?php echo "Fecha de ingreso: </strong><span class=\"view_detail\">".$f_ing; ?></h4>
		<h4><strong><?php echo "Fecha de salida: </strong><span class=\"view_detail\">".$f_sal; ?></h4>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<h4><strong><?php echo "Dirección: </strong><span class=\"view_detail\">".$direccion; ?></span></h4>
		<h4><strong><?php echo "Telefono: </strong><span class=\"view_detail\">".$tel; ?></span></h4>
		<h4><strong><?php echo "IMSS: </strong><span class=\"view_detail\">".$imss; ?></span></h4>
		<h4><strong><?php echo "No. IMSS: </strong><span class=\"view_detail\">".$no_imss; ?></span></h4>
		<h4><strong><?php echo "F.D.N.: </strong><span class=\"view_detail\">".$f_nam; ?></span></h4>
		<h4><strong><?php echo "CURP: </strong><span class=\"view_detail\">".$curp; ?></span></h4>
	</div>
	<div class="col-md-6">
		<h4><strong><?php echo "Razón social: </strong><span class=\"view_detail\">".$rs_nom; ?></span></h4>
		<h4><strong><?php echo "Puesto: </strong><span class=\"view_detail\">".$puesto; ?></span></h4>
		<h4><strong><?php echo "Sueldo: </strong><span class=\"view_detail\">".$sueldo; ?></span></h4>
	</div>
</div>
<?php require_once("../includes/footer.php"); ?>