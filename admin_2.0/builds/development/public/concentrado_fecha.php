<?php
require_once("../includes/php_init.php");

if(isset($_POST["submit"])) {
    //concetrado
    $bd=date("Y-m-d 00:00:01",strtotime($_POST["bd"]));
    $fd=date("Y-m-d 23:59:59",strtotime($_POST["fd"]));
    $sql="SELECT s.marca,s.plaza,s.ciudad,sum(a.tot_dia) as 'tot_dia',sum(a.tar) as 'tot_tar', sum(a.efe) as 'tot_efe' FROM sucursales s, av a WHERE s.id=a.id_suc";
    $sql.=" AND a.created_date BETWEEN '{$bd}' AND '{$fd}' GROUP BY a.id_suc";
    $res=exec_query($sql);
    $output="";
    while ($row=fetch($res)) {
        $tienda=tienda($row);
        $tar=money($row["tot_tar"]);
        $efe=money($row["tot_efe"]);
        $tot=money($row["tot_dia"]);
        $output.="<tr><td>{$tienda}</td>";
        $output.="<td>{$tar}</td>";
        $output.="<td>{$efe}</td>";
        $output.="<td>{$tot}</td></tr>";
    }

    //totales
    $sql_tot="SELECT sum(a.tot_dia) as 'tot_tot',sum(a.tar) as 'tot_tar', sum(a.efe) as 'tot_efe' FROM av a WHERE created_date BETWEEN '{$bd}' AND '{$fd}'";
    $res_tot=exec_query($sql_tot);
    $output_tot="";
    while ($row_tot=fetch($res_tot)) {
        $tot_tar=money($row_tot["tot_tar"]);
        $tot_efe=money($row_tot["tot_efe"]);
        $tot_tot=money($row_tot["tot_tot"]);
        $output_tot.="<tr><td>{$tot_tar}</td>";
        $output_tot.="<td>{$tot_efe}</td>";
        $output_tot.="<td>{$tot_tot}</td></tr>";
    }
    $subtitle=std_date($_POST["bd"])."/".std_date($_POST["fd"]);
}

$title="Concentadro por fecha";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row">
        <form action="concentrado_fecha.php" method="post">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Fecha de inicio</label>
                    <input type="date" class="form-control" name="bd">
                    <label for="">Fecha de terminación</label>
                    <input type="date" name="fd" class="form-control"><br>
                </div>
                <div class="col-md-4"><br>
                    <input type="submit" name="submit" value="Ver" class="btn btn-md btn-default">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Tienda</th>
                            <th>Tarjetas</th>
                            <th>Efectivo</th>
                            <th>Total</th>
                        </tr>
                        <?php if(isset($output)) echo $output; ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Totales</h2>
                    <table class="table table-striped">
                        <tr>
                            <th>Tarjeta</th>
                            <th>Efectivo</th>
                            <th>Total</th>
                        </tr>
                        <?php if(isset($output_tot)) echo $output_tot; ?>
                    </table>
                </div>
            </div>

        </form>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
