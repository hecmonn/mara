<?php
require_once("../includes/php_init.php");

$tiendas_arr=show_tiendas();
$tiendas=implode("\",\"",$tiendas_arr);
$metas_arr=get_metas_por();
$metas=implode("\",\"",$metas_arr);
$fp_arr=formas_pago();
$fp=implode("\",\"",$fp_arr);
require_once("../includes/header.php");
?>
<div class="container">
    <div class="graphs">
        <div class="row">
            <div class="col-md-6">
                <h3>Metas</h3>
                <canvas id="rs-ly" width="100" height="100"></canvas>
            </div>
            <div class="col-md-4">
                <h3>Formas de pago</h3>
                <canvas id="rs-lw" width="400" height="400"></canvas>
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
        labels: ["<?php echo $tiendas; ?>"],
        datasets: [{
            label: '# of Votes',
            data: ["<?php echo $metas; ?>"],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    max: 100 //sets maximum y axis value to 100
                }
            }]
        }
    }
});
var rsLw = $('#rs-lw');
var rsLwCh = new Chart(rsLw, {
    type: 'pie',
    data: {
        labels: ["Benivale","Univale","Coppel","Efectivo","Tarjetas"],
        datasets: [{
            label: 'Formas de pago',
            data: ["<?php echo $fp; ?>"],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
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
/*
var plLy = $('#pl-ly');
var plLyCh = new Chart(plLy, {
    type: 'line',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
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
var plLm = $('#pl-lm');
var plLmCh = new Chart(plLm, {
    type: 'pie',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
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
});*/
</script>
