<?php
require_once("../includes/php_init.php");
require_once("../includes/Facturas.php");
if(isset($_POST["submit"])){
    unset($_POST["submit"]);
    $cd=$_POST["created_date"];
    $days_exp=(int)$_POST["vencimiento"];
    $ven=date("Y-m-d",strtotime($cd ."+$days_exp days"));
    $nf=new Facturas();
    $nf->folio=strtoupper($_POST["folio"]);
    $nf->created_date=$cd;
    $nf->vencimiento=$ven;
    $nf->cantidad=(float)$_POST["cantidad"];
    $nf->id_prov=(int)$_POST["id_prov"];
    $nf->id_rs=(int)$_POST["id_rs"];
    $factura=$nf->create();
    if($factura){
        $_SESSION["message"]="Factura creada exitosamente";
    }
}
$title="Nueva factura";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="" action="factura_nueva" method="post">
                <label for="folio">Folio</label>
                <div class="input-group">
        			<div class="input-group-addon">#</div>
        		          <input type="text" name="folio" class="form-control" required>
        		</div><br>
                <label for="date">Fecha emitida</label>
                <input type="date" id="date" name="created_date" class="form-control" value="" required><br>
                <label for="date_ven">Días para vencer</label>
                <select class="form-control" name="vencimiento">
                    <option value="30">30</option>
                    <option value="60">60</option>
                    <option value="90">90</option>
                </select><br>
                <label for="prov">Proveedor</label>
                <select class="form-control" name="id_prov">
                    <?php
                        $sql="SELECT nombre,id FROM proveedores";
                        $res=exec_query($sql);
                        while ($row=fetch($res)) {
                            $id=$row["id"];
                            $prov=$row["nombre"];
                            echo "<option value='{$id}'>{$prov}</option>";
                        }
                    ?>
                </select><br>
                <label for="rs">Razón social</label>
                <select class="form-control" name="id_rs" required>
                    <?php
                        $sql="SELECT razon,id FROM razones_sociales";
                        $res=exec_query($sql);
                        while ($row=fetch($res)) {
                            $id=$row["id"];
                            $prov=$row["razon"];
                            echo "<option value='{$id}'>{$prov}</option>";
                        }
                    ?>
                </select><br>
                <label for="cantidad">Monto</label>
                <div class="input-group">
                    <div class="input-group-addon">$</div>
                <input type="number" name="cantidad" class="form-control" required>
                </div><br>
                <input type="submit" name="submit" value="Agregar" class="btn btn-md btn-default pull-right">
        </form>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
