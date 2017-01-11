<?php
require_once("../includes/php_init.php");
require_once("../includes/Facturas.php");
$output="";
$title="Facturas por proveedor";
if (isset($_POST["submit"])) {
    $pid=$_POST["id_prov"];
    $sql_prov="SELECT nombre FROM proveedores WHERE id={$pid}";
    $res_prov=exec_query($sql_prov);
    $prov=array_shift(fetch($res_prov));
    $subsub="";
    $sql="SELECT f.id,p.nombre,f.folio,f.created_date,f.vencimiento,f.cantidad,pa.restante FROM proveedores p JOIN facturas f ON p.id=f.id_prov AND id_prov={$pid}";
    $sql.=" LEFT JOIN pagos pa ON f.id=pa.id_fac";
    if(!empty($_POST["sd"]) && !empty($_POST["ed"])){
        $sd=date("Y-m-d 00:00:01",strtotime($_POST["sd"]));
        $ed=day($_POST["ed"]);
        $sql.=" AND f.created_date BETWEEN '{$sd}' AND '{$ed[1]}'";
        $subtitle="<br>".std_date($sd)." al ".std_date($ed[1])."<br>";
    }
    $sql.=" GROUP BY f.folio ORDER BY f.vencimiento DESC";
    $res=exec_query($sql);
    $output="<tbody id='fact-prov'>";
    while ($row=fetch($res)) {
        $id=$row["id"];
        $restante=$Facturas->cantidad_restante($id);
        $folio=$row["folio"];
        $sd=std_date($row["created_date"]);
        $ed=std_date($row["vencimiento"]);
        $monto=money($row["cantidad"]);
        $output.="</tr><td><a href='factura_ver.php?f={$id}'>{$folio}</a></td>";
        $output.="<td>{$sd}</td>";
        $output.="<td>{$ed}</td>";
        $output.="<td>{$monto}</td>";
        $output.="<td>{$restante}</td>";
        $output.="<td><a class='pagos-fac' folio='{$id}'>Pagos</a></td></tr>";
    }
    $output.="</tbody>";
    $title="Facturas de {$prov}";
}
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="supplier-selec" action="factura_proveedor" method="post">
                <div class="proveedor-selector">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="id_prov">Proveedor</label>
                            <select class="form-control" name="id_prov" required="true">
                                <option value="0" selected disabled>Seleccionar Proveedor</option>
                                <?php
                                    $sql="SELECT id,nombre FROM proveedores";
                                    $res=exec_query($sql);
                                    while ($row=fetch($res)) {
                                        $id=$row["id"];
                                        $prov=html_prep($row["nombre"]);
                                        echo "<option value='{$id}'>{$prov}</option>";
                                    }
                                ?>
                            </select>
                            <div class="error text-center" style="border:1px solid black;background-color: rgba(252,65,65,.5); color:white;padding:.5em;display:none;">Favor de seleccionar una razón</div><br>
                        </div>
                        <div class="proveedor-dates col-md-4" style="display:none;">
                            <label for="sd">Del:</label>
                            <input type="date" name="sd" class="form-control">
                            <label for="ed">Al:</label>
                            <input type="date" name="ed" class="form-control"><br>
                        </div>
                        <div class="col-md-3"><br>
                                <input type="submit" name="submit" value="Ver" id="sub" class="btn btn-md btn-default">
                                <a href="#" id="af">Agregar fecha</a>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="fact-prov-cont">
        <table class="table table-striped">
            <tr>
                <th>Folio</th>
                <th>Fecha emitida</th>
                <th>Vencimiento</th>
                <th>Monto</th>
                <th>Restante</th>
                <th>Ver pagos</th>
            </tr>
            <?php echo $output; ?>
        </table>
    </div>
    <div class="pagos-facturas-holder" style="display:none;">
        <div class="col-md-8">
            <h3>Pagos de factura <span class="fid-title"></span></h3>
            <table class="table table-striped pagos-factura">
                <tr>
                    <th>Fecha de pago</th>
                    <th>Cantidad pagada</th>
                    <th>Cantidad restante</th>
                </tr>
            </table>
            <div class="empty-pagos">
                <h3 class="text-center" style="display:none;"></h3>
            </div>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript">
    $(function(){
        $('#af').click(function(){
            $('.proveedor-dates').show("fast");
        });
        if($('#fact-prov').html().trim()===""){
            $('.fact-prov-cont').html("<h3 class='text-center'>Este proveedor no tiene facturas registradas</h3>");
        }
        $('.pagos-fac').click(function(){
            var fol=$(this).attr('folio');
            $.ajax({
                type:"POST",
                url:"../includes/ajax/pagos_prov.php",
                data:{folio:fol},
                success:
                    function(response){
                        console.log(response);
                        $('#pagos-content').remove();
                        $('.pagos-factura').append(response)
                    }
            })
        });
        $('#supplier-selec').submit(function(e){
            if($('select').val()===null){
                e.preventDefault();
                $('.error').show();
            }
        });
        $('.pagos-fac').click(function(){
            $('.pagos-facturas-holder').show();
            /*if($('#pagos-content').html().trim()===""){
                $('.pagos-factura').hide();
                $('.empty-pagos').show();
                //$('.pagos-factura').html('<h3 class="text-center">No se han registrado pagos para esta factura</h3>');
            } else {
                $('.pagos-factura').show();
                $('.empty-pagos').hide();
            }*/
        });
    });
</script>
