<?php
require_once("../includes/php_init.php");
require_once("../includes/Facturas.php");
$output="";
$title="Facturas por razón social";
if (isset($_POST["submit"])) {
    $rid=$_POST["id_rs"];
    $sql_rs="SELECT razon FROM razones_sociales WHERE id={$rid}";
    $res_rs=exec_query($sql_rs);
    $rs=array_shift(fetch($res_rs));
    $subsub="";
    $sql="SELECT f.id,rs.razon,f.folio,f.created_date,f.vencimiento,f.cantidad,pa.restante,p.nombre FROM razones_sociales rs JOIN facturas f ON rs.id=f.id_rs AND id_rs={$rid}";
    $sql.=" LEFT JOIN pagos pa ON f.id=pa.id_fac JOIN proveedores p ON f.id_prov=p.id GROUP BY f.folio ORDER BY f.vencimiento DESC";
    if(!empty($_POST["sd"]) && !empty($_POST["ed"])){
        $sd=date("Y-m-d 00:00:01",strtotime($_POST["sd"]));
        $ed=day($_POST["ed"]);
        $sql="SELECT f.id,rs.razon,f.folio,f.created_date,f.vencimiento,f.cantidad,pa.restante,p.nombre FROM razones_sociales rs JOIN facturas f ON rs.id=f.id_rs AND id_rs={$rid}";
        $sql.=" AND f.created_date BETWEEN '{$sd}' AND '{$ed[1]}' LEFT JOIN pagos pa ON f.id=pa.id_fac JOIN proveedores p ON f.id_prov=p.id GROUP BY f.folio ORDER BY f.vencimiento DESC";
        $subtitle="<br>".std_date($sd)." al ".std_date($ed[1])."<br>";
    }
    $res=exec_query($sql);
    $output="<tbody id='fact-prov'>";
    while ($row=fetch($res)) {
        $id=$row["id"];
        $sql_restante="SELECT restante FROM pagos WHERE id_fac={$id} ORDER BY created_date DESC";
        $res_restante=exec_query($sql_restante);
        $restante=$Facturas->cantidad_restante($id);
        $folio=$row["folio"];
        $prov=html_prep($row["nombre"]);
        $sd=std_date($row["created_date"]);
        $ed=std_date($row["vencimiento"]);
        $monto=money($row["cantidad"]);
        $output.="<tr><td><a href='factura_ver.php?f={$id}'>{$folio}</a></td>";
        $output.="<td>{$prov}</td>";
        $output.="<td>{$sd}</td>";
        $output.="<td>{$ed}</td>";
        $output.="<td>{$monto}</td>";
        $output.="<td>{$restante}</td>";
        $output.="<td><a class='pagos-fac' folio='{$id}'>Pagos</a></td></tr>";
    }
    $output.="</tbody>";
    $title="Facturas de {$rs}";
}
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="supplier-selec" action="factura_rs" method="post">
                <div class="proveedor-selector">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="id_prov">Proveedor</label>
                            <select class="form-control" name="id_rs" required="true">
                                <option value="0" selected disabled>Seleccionar razón social</option>
                                <?php
                                    $sql="SELECT id,razon FROM razones_sociales";
                                    $res=exec_query($sql);
                                    while ($row=fetch($res)) {
                                        $id=$row["id"];
                                        $rs=html_prep($row["razon"]);
                                        echo "<option value='{$id}'>{$rs}</option>";
                                    }
                                ?>
                            </select>
                            <div class="error text-center" style="border:1px solid black;background-color: rgba(252,65,65,.5); color:white;padding:.5em;display:none;">Favor de seleccionar proveedor</div><br>
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
                <th>Proveedor</th>
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
            $('.fact-prov-cont').html("<h3 class='text-center'>Esta razón no tiene facturas registradas</h3>");
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
