<?php 
require_once("../includes/php_init.php");
require_once("../includes/password.php");

if(isset($_POST["submit"])){
	$pass=mysql_prep($_POST["pass"]);
	$us=mysql_prep($_POST["us"]);
	$id=$_POST["id"];
	$hashed_pass=password_hash($pass, PASSWORD_DEFAULT);
	$sql_ti="INSERT INTO usuarios_suc(usuario,password,id_suc) VALUES('{$us}','{$hashed_pass}','{$id}')";
	$res_ti=exec_query($sql_ti);
	if($res_ti){
		$_SESSION["message"]="OK";
		redirect_to("tienda_us.php");
	}
}
$title="Nueva tienda us";
require_once("../includes/header.php");
?>
<form action="tienda_us.php" method="post">
<select name="id">
	<?php 
	$sql= "SELECT * FROM sucursales WHERE id NOT IN(select id_suc from usuarios_suc)";
	$res=exec_query($sql);
	while($row=fetch($res)){
		$id=$row["id"];
		$nom=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
		echo "<option value={$id}>{$nom}</option>";
	}
	?>
</select><br>
	<input type="text" name="us"><br>
	<input type="text" name="pass"><br>
	<input type="submit" name="submit">
</form>
<?php require_once("../includes/footer.php"); ?>