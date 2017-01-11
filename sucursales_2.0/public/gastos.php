<?php
require_once("../includes/php_init.php");  
require_once("../includes/Gastos.php");
$av=$_GET["av"];
if(isset($_POST["submit"])){
	$canti=count($_POST["descr"]);
	exec_query("begin");
	for($i=0; $i<$canti; $i++){
		$descr=mysql_prep($_POST["descr"][$i]);
		$cantidad=mysql_prep($_POST["cantidad"][$i]);
		$sql_gas="INSERT INTO gastos(descr,cantidad,id_av) VALUES('{$descr}','{$cantidad}','{$av}')";
		$res_gas=exec_query($sql_gas);
	}
	if($res_gas){
		exec_query("commit");
		$_SESSION["message"]="¡GRACIAS!";
		redirect_to("index.php");
	}
	else{
		exec_query("rollback");
		$_SESSION["message"]="Favor de ingresar gastos de nuevo";
		redirect_to("gastos.php");
	}
}
$title="Gastos";
require_once("../includes/header.php");
?>
<h1>Favor de registrar sus gastos</h1>
<div class="col-md-6">
	<form action="gastos.php?av=<?php echo $av; ?>" method="post">
		<table class="table table-striped" id="gastos">
			<tr>
				<th>Descripcion</th>
				<th>Cantidad</th>
				<th> </th>
			</tr>
			<tr>
				<td><input type="text" name="descr[]" class="form-control"></td>
				<td><div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" name="cantidad[]" class="form-control">
				</div></td>
				<td><button type="button" id="add" class="btn btn-success">+</button></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Capturar" class="btn btn-success pull-right">
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var i=1;
		$('#add').click(function(){
			i++;
			$('#gastos').append('<tr id="row'+i+'"><td><input type="text" name="descr[]" class="form-control"><td><div class="input-group"><div class="input-group-addon">$</div><input type="text" name="cantidad[]" class="form-control"></div></td></td><td><button name="remove" id="'+i+'"class="btn btn-danger btnRemove">-</tr>');
		});
		$(document).on('click','.btnRemove',function(){
			var btnId=$(this).attr('id');
			$('#row'+btnId+'').remove();
		})
	});
</script>

<?php require_once("../includes/footer.php"); ?>