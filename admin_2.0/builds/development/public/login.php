<?php
require_once("../includes/Session.php");
require_once("../includes/functions.php");
require_once("../includes/Database.php");
require_once("../includes/password.php");
if(isset($_POST["submit"])){
	if(empty($_POST["user"]) OR empty($_POST["password"])){
		$_SESSION["message"]="Please fill username and password.";
		redirect_to("login.php");
	}
	$user = $_POST["user"];
	$password = $_POST["password"];
	$user_found = attempt_login($user, $password, "usuarios");
	if($user_found){
		$_SESSION["id_admin"] = $user_found["id"];
		$_SESSION["user_admin"] = $user_found["usuario"];
		$_SESSION["role"]=$user_found["type"];
		$_SESSION["message"]="¡Bienvenido!";
		redirect_to("index.php");
	}
	else{
		$_SESSION["message"]="Usuario/contraseña incorrecto";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>MARA | Iniciar sesión</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="login-form">
			<img src="images/logo.png" width="380" height="225"><br><br>
			<form action="login.php" method="post">
				<?php echo session_message(); ?><br>
				<input type="text" name="user" placeholder="Usuario" class="form-control" required><br>
				<input type="password" name="password" placeholder="Contrasena" class="form-control" required><br>
				<input type="submit" name="submit" class="btn btn-default center-block" value="Iniciar sesión">
			</form>
		</div>
	</div>
</div>
</body>
<footer>
	<hr>
	<p style="text-align:center;">Grupo Mara Empresarial&copy; <br>2016</p>

</footer>
</html>
