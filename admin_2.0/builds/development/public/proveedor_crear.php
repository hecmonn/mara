<?php
require_once("../includes/php_init.php");
require_once("../includes/Proveedores.php");
if(isset($_POST["submit"])){
    $prov=new Proveedores();
    $prov->persona=$_POST["persona"];
    $prov->concepto=$_POST["concepto"];
    $prov->ciudad=$_POST["ciudad"];
    $prov->rfc=strtoupper($_POST["rfc"]);
    $prov->contacto=$_POST["contacto"];
    $prov->banco=$_POST["banco"];
    $prov->cuenta=$_POST["cuenta"];
    $prov->clabe=$_POST["clabe"];
    $prov->nombre=$_POST["nombre"];
    $prov->pais=$_POST["pais"];
    $prov->apellido_materno=$_POST["apellido_materno"];
    $prov->apellido_paterno=$_POST["apellido_paterno"];
    $prov->direccion=!empty($_POST["direccion_2"])?$_POST["direccion_1"]." ".$_POST["direccion_2"]:$_POST["direccion_1"];
    $prov->created_date=date("Y-m-d",strtotime("today"));
    $nuevo=$prov->create();
    if($nuevo){
        $_SESSION["message"]="Proveedor creado exitósamente";
        redirect_to("proveedores");
    }
}
$title="Nuevo proveedor";
require_once("../includes/header.php");
?>
<div class="container">
    <form action="proveedor_crear" method="post">
        <div class="row">
            <h3>Registro</h3><hr>
            <div class="col-md-3">
                <label for="">Persona</label>
                <select class="form-control" id="persona" name="persona">
                    <option value="moral" selected>Moral</option>
                    <option value="fisica">Fisica</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Concepto</label>
                <select class="form-control" name="concepto">
                    <option value="comercial">Comercial</option>
                </select>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-3">
                <label for="">Nombre</label>
                <input type="text" class="form-control" name="nombre">
            </div>
            <div class="persona-selector" style="display:none">
                <div class="col-md-3">
                    <label for="">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="">Apellido paterno</label>
                    <input type="text" name="apellido_materno" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3>Contacto</h3><hr>
                <label for="">Nombre del contacto</label>
                <input type="text" name="contacto" class="form-control"><br>
                <label for="">Ciudad</label>
                <input type="text" name="ciudad" class="form-control"><br>
                <label for="">País</label>
                <select class="form-control" name="pais" class="form-control">
                    <option value="mexico">México</option>
                    <option value="portugal"> Portugal</option>
                    <option value="italia">Italia</option>
                    <option value="brazil">Brazil</option>
                </select><br>
                <label for="">Dirección</label>
                <input type="text" name="direccion_1" class="form-control">
                <input type="text" name="direccion_2" class="form-control"><br>
            </div>
            <div class="col-md-4"><br><br><br><br>
                <label for="">RFC</label>
                <input type="text" name="rfc" class="form-control"><br>
                <label for="">Teléfono</label>
                <input type="tel" name="telefono" class="form-control"><br>
            </div>
            <div class="col-md-4">
                <h3>Información de pago</h3><hr>
                <label for="">Banco</label>
                <select class="form-control" name="banco">
                    <option value="bbva">Bancomer</option>
                </select><br>
                <label for="">Cuenta</label>
                <input type="number" name="cuenta" class="form-control"><br>
                <label for="">Clabe</label>
                <input type="text" name="clabe" class="form-control"><br>
                <input type="submit" name="submit" value="Crear" class="btn btn-md btn-default pull-right">
            </div>
        </div>
    </form>
</div>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript">
    $(function(){
        $('#persona').change(function(){
            var per=$(this).val().trim();
            if(per==="fisica"){
                $('.persona-selector').show("fast");
            } else if(per==="moral"){
                $('.persona-selector').hide();
            }
        });
    });
</script>
