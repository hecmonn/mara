<?php
require_once("../includes/php_init.php");
$si=(int)$_SESSION["id_sucursal"];
$curr_month=date("m",strtotime("today"));
$cy=date("Y",strtotime("today"));
$sql_meta="SELECT meta FROM metas WHERE id_suc={$tid} AND month(created_date)={$curr_month}";
$res_meta=exec_query($sql_meta);
$meta=money_format('%i',(float)array_shift(fetch($res_meta)));
$dias=(int)date("j",strtotime("today"));
$dm=cal_days_in_month(CAL_GREGORIAN, $curr_month, $cy);
$cd=date('Y-m-d',strtotime("today"));
$bd=date('Y-m-01',strtotime("today"));
$tot_days=date("d",strtotime("today"));
$sql_vt="SELECT sum(tot_dia) FROM av WHERE created_date BETWEEN '{$bd} 00:00:01' AND '{$cd} 23:59:59' AND id_suc={$si}";
$res_vt=exec_query($sql_vt);
$vt=array_shift(fetch($res_vt));
$curr_por=(int)(($vt*100/$meta));
$meta_prog=number_format($meta,2,'.',',');
$ideal_diario=(float)($meta/$dm);
$ideal_por=(int)((($ideal_diario*$tot_days)*100)/$meta);
$meta_diario=number_format($ideal_diario,2,'.',',');

require_once("../includes/header.php"); ?>
<div class="container">
    <div class="index-header text-center">
        <h2>Mara Grupo Empresarial</h2>
        <h4 class="text-muted">Sucursales</h4><hr>
    </div>
    <div class="index-content">

        <div class="col-md-8">
            <div class="col-md-8">
                <h3>Meta</h3>
                <canvas id="rs-ly" width="600" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <br><br><br>
                <h4>Meta del mes: $<?php echo $meta_prog; ?></h4>
                <h4>Meta diaria: $<?php echo $meta_diario; ?></h4>
                <h4>Porcentaje: <?php echo $curr_por."%"; ?></h4>
            </div>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
var rsLy = $('#rs-ly');
var rsLyCh = new Chart(rsLy, {
    type: 'bar',
    data: {
        labels: ["Meta"],
        datasets: [{
            label: 'Ideal',
            data: [<?php echo $ideal_por; ?>],
            backgroundColor: [
                'rgba(66, 244, 89,.5)',
            ],
            borderColor: [
                'rgba(2, 2, 2,.5)',
            ],
            borderWidth: 1
        },
        {
            label: 'Actual',
            data: [<?php echo $curr_por; ?>],
            backgroundColor: [
                'rgba(66, 134, 244,.5)',
            ],
            borderColor: [
                'rgba(66, 134, 244,.5)',
            ],
            borderWidth: 1
        }],

    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
