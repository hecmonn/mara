<?php 

		define("DB_SERVER", "grupomara.mx");
		define("DB_USER", "grupom13_admin");
		define("DB_PASS", "5r9AVnR+R#c)");
		define("DB", "grupom13_mara_production");
		$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB);
		if(mysqli_errno($con)){
			die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_error().")");
		}
		else{ echo "Succes."; }
 ?>