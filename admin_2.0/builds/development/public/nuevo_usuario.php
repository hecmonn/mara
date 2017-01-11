<?php
$title="Usuario nuevo";
require_once("../includes/header.php");
require_once("../includes/password.php");
if(isset($_POST["submit"])){
	$username = mysql_prep($_POST["username"]);
	$password = mysql_prep($_POST["password"]);
	$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
	exec_query("begin;");
	$sql_user ="INSERT INTO usuarios(usuario, password, type) VALUES ('" . $username . "','" . $hashed_pass . "', '1')";
	$res_us = exec_query($sql_user);

	if($res_us) {
		exec_query("commit;");
		$_SESSION["message"] = "Usuario creado con éxito";
		redirect_to("index.php");
	}else {
		exec_query("rollback;");
		$_SESSION["message"] = "Intentar de nuevo";
		redirect_to("nuevo_usuario.php");
	}
}
?>
<div class="container-fluid">
	<a href="index.php">&laquo;Back</a><br><br>
	<form action="nuevo_usuario.php" method="post">
		<div class="col-md-4">
			<label>Usuario</label>
			<input type="text" name="username" class="form-control" required><br>
			<label>Contraseña</label>
			<input type="password" name="password" id="password" class="form-control"><br>
			<input type="password" name="passwordconf" id="passwordconf" class="form-control" placeholder="Confirmar constraseña" oninput="check(this)"><br>
			<script language='javascript' type='text/javascript'>
				function check(input) {
				    if (input.value != document.getElementById('password').value) {
				        input.setCustomValidity('Passwords does not match.');
				    } else {
				        // input is valid -- reset the error message
				        input.setCustomValidity('');
				   }
				}
				</script>
			<input type="submit" name="submit" value="Crear" class="btn btn-success">
	</form>
		</div>
	</div>
</div>
<?php include_once("../includes/footer.php"); ?>
