<?php
require_once("../includes/php_init.php");
if(isset($_POST["submit"])){
    $suc=mysql_prep($_POST["sucursal"]);
    $meta=mysql_prep($_POST["meta"]);
    $sql_meta="INSERT INTO metas(id_suc,meta) VALUES({$suc},{$meta})";
    $res_meta=exec_query($sql_meta);
    if($res_meta){
        $sql_suc="SELECT * FROM sucursales WHERE id={$suc}";
        $res_suc=exec_query($sql_suc);
        while ($row=fetch($res_suc)) {
            $tienda=tienda($row);
        }
        $_SESSION["message"]="Meta de {$tienda} capturada";
    }
}
$curr_month=date("F Y",strtotime("today"));
$cmn=date("m",strtotime("today"));
$title="Metas";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="col-md-4 col-md-offset-4">
        <div class="cm-header">
            <p class="text-center">
                Estas capturando para <?php echo $curr_month; ?>
            </p>
        </div>
        <div class="cm-content">
            <div class="cm-form">
                <form action="captura_metas" method="post">
                    <label for="sucursal">Sucursal</label><br>
                    <select class="form-control" name="sucursal">
                        <?php
                            $sql="SELECT * FROM sucursales WHERE id NOT IN (SELECT id_suc FROM metas WHERE month(created_date)={$cmn}) ";
                            $res=exec_query($sql);
                            while ($row=fetch($res)) {
                                $id=$row["id"];
                                $tienda=tienda($row);
                                echo "<option value=\"{$id}\">{$tienda}</option>";
                            }
                        ?>
                    </select><br>
                    <label for="imss">Meta</label><br>
            		<div class="input-group">
            			<div class="input-group-addon">$</div>
            		          <input type="text" name="meta" class="form-control">
            		</div>
                    <small>La meta del año pasado fue $xxx</small><br>
                    <input type="submit" name="submit" value="Capturar" class="btn btn-md btn-default pull-right">
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
