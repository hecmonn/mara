<?php
require_once("../includes/php_init.php");
if(isset($_POST["submit"])){
	$us=mysql_prep($_POST["usuario"]);
	$km_ini=mysql_prep($_POST["km_ini"]);
	$km_final=mysql_prep($_POST["km_final"]);
	$lts=mysql_prep($_POST["lts"]);
	$mxn=mysql_prep($_POST["mxn"]);
	$sql_gas="INSERT INTO gasolina(usuario,km_in,km_f,lts,mxn) VALUES(";
	$sql_gas.="'{$us}','{$km_ini}','{$km_final}','{$lts}','{$mxn}')";
	$res_gas=exec_query($sql_gas);
	if($res_gas){
    $_SESSION["message"]="Consumo de gasolina registrado";
    redirect_to("index.php");
	}
$title="Gasolina";
require_once("../includes/header.php");
?>
<form class="" action="gasolina.php" method="post">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
            	<label>Usuario</label>
                <select class="form-control" name="usuario">
                    <option disabled selected>Seleccionar usuario</option>
                    <option value="hector">Héctor</option>
                    <option value="eunir">Eunir</option>
                    <option value="elia">Elia</option>
                    <option value="denisse">Denisse</option>
                    <option value="yuridia">Yuridia</option>
                    <option value="sofia">Sofia</option>
                </select><br>
                <label>Kilometraje inicial</label>
                <input type="number" step=".1" min="0" name="km_ini" class="form-control"><br>
                <label>Kilometraje final</label>
                <input type="number" step=".1" min="0" name="km_final" class="form-control"><br>
            </div>
            <div class="col-md-4">
                <label>Gasolina</label>
                <input type="number" step=".1" min="0" name="lts" class="form-control"><br>
                <label>Pesos MXN</label>
                <input type="number" step=".1" min="0" name="mxn" class="form-control"><br><br>
                <input type="submit" name="submit" class="btn btn-success pull-right" value="Capturar">
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</form>
<?php require_once("../includes/footer.php"); ?>
