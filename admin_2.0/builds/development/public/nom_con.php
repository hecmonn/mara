<?php
require_once("../includes/php_init.php");
$fortnigth=quincena();
$q=isset($_GET["q"])?$_GET["q"]:$fortnigth[0];
$sql_nom="select n.sueldo,n.comisiones,n.descanso,n.faltas,n.nom_tot,e.nombre,e.id";
$sql_nom.=" from nomina n, empleados e where n.id_em=e.id and n.quin='{$q}'";
$res_nom=exec_query($sql_nom);
$sql_to="select sum(comisiones),sum(nom_tot),sum(credifam)";
$sql_to.=" from nomina where quin='{$q}'";
$res_tot=exec_query($sql_to);
$tot_output="";
while ($row=fetch($res_tot)) {
	$tot_output.="<tr><td>".money_format('%i', $row["sum(comisiones)"])."</td>";
	$tot_output.="<td>".money_format('%i', $row["sum(credifam)"])."</td>";
	$tot_output.="<td>".money_format('%i', $row["sum(nom_tot)"])."</td></tr>";
}
$sql_no_nom="SELECT quin FROM nomina GROUP BY quin";
$res_no_nom=exec_query($sql_no_nom);
$title="Nomina";
require_once("../includes/header.php");
?>
<div class="row">
	<div class="col-md-4">
		<form action="nom_con.php" method="get">
			<select name="q" class="form-control">
		<?php
				while ($row=fetch($res_no_nom)) {
					$quin=date("Y-m-d",strtotime($row["quin"]));
					$fecha=date("Y-M-d",strtotime($row["quin"]));
					echo "<option value={$quin}>{$fecha}</option>";
				}
		?>
			</select>
	</div>
	<div class="col-md-8">
			<input type="submit" name="submit" value="Ver" class="btn btn-success">
		</form>
	</div>
</div><br>
	<div id="nomina-holder">
		<table class="table table-striped">
			<tr>
				<th>Nombre</th>
				<th>Sueldo Fiscal</th>
				<th>Comisiones</th>
				<th>Descansos</th>
				<th>Faltas</th>
				<th>Total</th>
			</tr>
			<?php
			$output="<tbody id=\"nomina-content\">";
				while ($row=fetch($res_nom)) {
					$id=$row["id"];
					$output.="<tr><td><a href=\"ver_nom_em.php?e={$id}&q={$q}\">".html_prep($row["nombre"])."</a></td>";
					$output.="<td>".money_format('%i',$row["sueldo"])."</td>";
					$output.="<td>".money_format('%i',$row["comisiones"])."</td>";
					$output.="<td>".html_prep($row["descanso"])."</td>";
					$output.="<td>".html_prep($row["faltas"])."</td>";
					$output.="<td>".money_format('%i',$row["nom_tot"])."</td></tr>";
				}
				$output.="</tbody>";
			 ?>

			<?php echo $output; ?>
		</table>
		<h2>Totales</h2>
			<table class="table table-striped">
			<tr>
				<th>Comisiones</th>
				<th>Credifam</th>
				<th>Nomina total</th>
			</tr>
		<?php echo $tot_output; ?>
		</table>
	</div>

<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript">
	$(function(){
		var infoNom=$('#nomina-content').html().trim();
		if(infoNom===""){
			$('#nomina-holder').html("<h3 class=\"text-center\">Seleccionar quincena a ver</h3>");
		}
	});
</script>
