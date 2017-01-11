<?php
$title="Captura";
require_once("../includes/php_init.php");
require_once("../includes/Av.php");
$id_suc=$_SESSION["id_sucursal"];
if(isset($_POST["submit"])){
	//cleaned attributes to pass to confirmation page
	$efe=html_prep($_POST["efe"]);
	$tot=html_prep($_POST["tot_dia"]);
	$tar=html_prep($_POST["tar"]);
	$tck1=html_prep($_POST["tck1"]);
	$tck2=html_prep($_POST["tck2"]);

	//arrange gastos var
	$gastos_temp=[];
	$canti=count($_POST["descr"]);
	for($i=0; $i<$canti; $i++){
		$gastos_temp["descr"][$i]=$_POST["descr"][$i];
		$gastos_temp["cantidad"][$i]=$_POST["cantidad"][$i];
	}

	//insert captura
	$captura=$Av->create();

	//insert gastos to table
	if($captura){
		$id_av=mysqli_insert_id($Database->con);
		$sql_up="UPDATE av SET id_suc={$id_suc} WHERE id={$id_av}";
		$res_up=exec_query($sql_up);
		exec_query("begin");
		$canti=count($gastos_temp["descr"]);
		for($i=0; $i<$canti; $i++){
			$descr=mysql_prep($gastos_temp["descr"][$i]);
			$cantidad=mysql_prep($gastos_temp["cantidad"][$i]);
			$sql_gas="INSERT INTO gastos(descr,cantidad,id_av) VALUES('{$descr}','{$cantidad}','{$id_av}')";
			$res_gas=exec_query($sql_gas);
			$sqltemp.=$sql_gas;
		}

		//redirect to confirmation
		if($res_gas){
			exec_query("commit");
			$_SESSION["message"]="¡GRACIAS!";
			redirect_to("confirmacion.php?e={$efe}&t={$tot}&tar={$tar}&t1={$tck1}&t2={$tck2}");
		}

		//safety net to insert gastos
		else{
		exec_query("rollback");
		$_SESSION["message"]="Favor de intentar de nuevo";
		redirect_to("gastos.php?av=$id_av");
		}
	}
}
require_once("../includes/header.php");
?>
<form action="av.php?s=<?php echo $id_suc; ?>" method="post">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-3">
				<label>Ticket incial</label>
				<div class="input-group">
					<div class="input-group-addon">#</div>
					<input type="text" name="tck1" min="0" step="1" id="tck1" class="form-control">
				</div><br>
			</div>
			<div class="col-md-3">
				<label>Ticket final</label>
				<div class="input-group">
					<div class="input-group-addon">#</div>
					<input type="text" name="tck2" id="tck2" min="0" step="1" class="form-control">
				</div><br>
			</div>
			<div class="col-md-3">
				<small>Numero de tickets:<span id="tickets"></span></small>
			</div>
		</div>
		<hr>
		<div class="col-md-3">
			<h3>Tarjetas</h3><hr>
			<label>Banamex</label><br>
			<div class="input-group fp">
				<div class="input-group-addon">$</div>
				<input type="number" name="bmx" id="bmx" min="0" step=".01" class="form-control bmx">
			</div><br>
			<label>BanBajio</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="bbjio" id="bbjio" min="0" step=".01" class="form-control">
			</div><br>
			<label>American Express</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="amex" id="amex" min="0" step=".01" class="form-control">
			</div><br>
			<label>Scotia Bank</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="sb" id="sb" min="0" step=".01" class="form-control">
			</div><br>
			<label>Santander</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="santander" id="san" min="0" step=".01" class="form-control">
			</div><br>
		</div>
		<div class="col-md-3 formasPago">
			<h3>Formas de pago</h3><hr>
			<label>MoneyCard</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="mc" min="0" step=".01" class="form-control fp_no-suma">
			</div><br>
			<label>Coppel</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="coppel" min="0" step=".01" class="form-control fp">
			</div><br>
			<label>Univale</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="univale" min="0" step=".01" class="form-control fp">
			</div><br>
			<label>Coupon Cloud</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="cc" min="0" step=".01" class="form-control fp">
			</div><br>
			<label>Vales de caja</label><br>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="vc" min="0" step=".01" class="form-control fp_no-suma">
			</div><br>
		</div>
		<div class="col-md-3">
			<h3>Totales</h3><hr>
			<label>Efectivo</label>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="efe" id="efe" min="0" step=".01" class="form-control">
			</div><br>
			<label>Dolares</label>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="dolares" id="dol" min="0" step=".01" class="form-control">
			</div>
			<small>Convertido a MXN</small><br>
			<label>Tarjetas</label>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="tar" id="toTar" class="form-control" readonly>
			</div><br>
			<label>Fondo</label>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="fondo" id="fondo" min="0" step=".01" class="form-control" placeholder="500">
			</div><br>

		</div>
		<div class="col-md-3" id="bottom">

		</div>
	</div>
<div class="col-md-12">
	<div class="row">
		<div class="col-md-6">
			<h3>Gastos</h3>
			<table class="table table-striped" id="gastos">
				<tr>
					<th>Descripcion</th>
					<th>Cantidad</th>
					<th> </th>
				</tr>
				<tr>
					<td><input type="text" name="descr[]" class="form-control"></td>
					<td><div class="input-group">
						<div class="input-group-addon">$</div>
						<input type="text" name="cantidad[]" class="form-control gas">
					</div></td>
					<td><button type="button" id="add" class="btn btn-success">+</button></td>
				</tr>
			</table>
		</div>
		<div class="col-md-4">
		<h3>Venta total</h3>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="tot_dia" min="0" step=".01" id="vf" class="form-control" required>
			</div><br>
		<h3>Corte de caja</h3>
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="number" name="corte" class="form-control" id="cc" readonly>
			</div><br>
			<small id="difHolder" style="display:none">Tienes una diferencia de <span id="dife"></span></small>

			<input type="hidden" id="gas" disbaled>
			<input type="hidden" id="formasPag" disabled>
			<button type="button" id="conf-btn" class="btn btn-success btn-lg pull-right" data-toggle="modal" data-target="#myModal">Capturar</button>
		</div>

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title text-center" id="myModalLabel">CONFIRMACIÓN</h2>
        <small>Favor de confirmar que los datos sean correctos, de lo contrario cerrar esta ventana y corregirlos.</small>
      </div>
      <div class="modal-body">
        <div id="conf-venta">
        		<div class="row">
	        		<div class="col-md-6">
			        	<strong>Total de efectivo $</strong><span id="efe-conf"></span><br>
			        	<strong>Total de tarjetas $</strong><span id="tar-conf"></span><br>
			        </div>
			        <div class="col-md-6">
			        	<strong>Corte de caja $</strong><span id="corte-conf"></span><br>
			        	<strong>Venta del día $</strong><span id="vf-conf"></span><br><br>
	        			<strong>Diferencia $</strong><span id="dif-conf"></span>
	        		</div>
	        	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		<input type="submit" name="submit" value="Confirmar" class="btn btn-success pull-right">
      </div>
    </div>
  </div>
</div>
</form>



<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript">
	function getTar(){
		$('#bmx,#bbjio,#amex,#san,#sb').on('input',function(){
			var bmx=0;
			var bbjio=0;
			var amex=0;
			var sb=0;
			var sant=0;
			$('#bmx').val()>0? bmx=$('#bmx').val():bmx=0;
			$('#bbjio').val()>0? bbjio=$('#bbjio').val():bbjio=0;
			$('#amex').val()>0? amex=$('#amex').val():amex=0;
			$('#san').val()>0? sant=$('#san').val():sant=0;
			$('#sb').val()>0?sb=$('#sb').val():sb=0;
			var totTar=parseFloat(bmx)+parseFloat(bbjio)+parseFloat(amex)+parseFloat(sant)+parseFloat(sb);
			$('#toTar').val(totTar);
		});
	}
	$(document).ready(function(){
		var i=1;
		getTar();
		$('#tck1,#tck2').change(function(){
			var tc2=0;
			var tc1=0;
			$('#tck2').val()>0? tc2=$('#tck2').val():tc2=0;
			$('#tck1').val()>0? tc1=$('#tck1').val():tc1=0;
			var tot=parseInt(tc2)-parseInt(tc1);
			$('#tickets').html('<h4>'+parseInt(tot)+'</h4>');
		});
		$('#add').click(function(){
			i++;
			$('#gastos').append('<tr id="row'+i+'"><td><input type="text" name="descr[]" class="form-control"><td><div class="input-group"><div class="input-group-addon">$</div><input type="text" name="cantidad[]" class="form-control gas"></div></td></td><td><button name="remove" id="'+i+'"class="btn btn-danger btnRemove">-</tr>');
		});
		$(document).on('click','.btnRemove',function(){
			var btnId=$(this).attr('id');
			$('#row'+btnId+'').remove();
		});
		//suma ingresos
		$('.fp').on('input',function(){
			var totPagos=0;
			$('.formasPago .fp').each(function(){
				var element=$(this).val()>0?$(this).val():0;
				totPagos+=parseFloat(element);
				$('#formasPag').val(totPagos);
			});
		});
		//sumar gastos
		$('#gastos').on('input',function(){
			var totGas=0;
			$('#gastos .gas').each(function(){
				var ele=$(this).val()>0?$(this).val():0;
				totGas+=parseFloat(ele);
				$('#gas').val(totGas);
			});
		});
		//suma corteCaja
		$('#vf').on('input',function(){
			var totTar=parseFloat($('#toTar').val())>0?parseFloat($('#toTar').val()):0;
			var totGas=parseFloat($('#gas').val())>0?parseFloat($('#gas').val()):0;
			var totPag=parseFloat($('#formasPag').val())>0?parseFloat($('#formasPag').val()):0;
			var efe=parseFloat($('#efe').val())>0?parseFloat($('#efe').val()):0;
			var dol=parseFloat($('#dol').val())>0?parseFloat($('#dol').val()):0;
			var cc=totTar+totGas+totPag+efe+dol;
			$('#cc').val(cc);

			var cc=parseFloat($('#cc').val())>0?parseFloat($('#cc').val()):0;
			var vf=parseFloat($('#vf').val())>0?parseFloat($('#vf').val()):0;
			var dif=parseFloat(vf)-parseFloat(cc);
			$('#difHolder').css('display','block');
			if(cc<vf){
				$('#dife, #dif-conf').css('color','green');
				$('#dife').html('<h4>+$'+parseFloat(dif).toFixed(2)+'</h4>');
			} else{
				$('#dife, #dif-conf').css('color','red');
				$('#dife').html('<h4>$'+parseFloat(dif).toFixed(2)+'</h4>');
			}
		});
		$('#conf-btn').click(function(){
			var totTar=parseFloat($('#toTar').val())>0?parseFloat($('#toTar').val()):0;
			var totGas=parseFloat($('#gas').val())>0?parseFloat($('#gas').val()):0;
			var totPag=parseFloat($('#formasPag').val())>0?parseFloat($('#formasPag').val()):0;
			var efe=parseFloat($('#efe').val())>0?parseFloat($('#efe').val()):0;
			var dol=parseFloat($('#dol').val())>0?parseFloat($('#dol').val()):0;
			var vf=parseFloat($('#vf').val())>0?parseFloat($('#vf').val()):0;
			var cc=totTar+totGas+totPag+efe+dol;
			var dif=parseFloat(vf)-parseFloat(cc);

			$('#tar-conf').html(totTar);
			$('#efe-conf').html(efe);
			$('#corte-conf').html(cc);
			$('#vf-conf').html(vf);
			$('#dif-conf').html(dif);
		});
	});
</script>
