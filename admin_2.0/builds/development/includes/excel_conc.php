<?php  
require_once("php_init.php");
$fs=$_GET["fs"];
$ff=$_GET["ff"];
$t=$_GET["s"];
$fn_fs=date("Y-m",strtotime($fs));
$fn_ff=date("Y-m",strtotime($ff));
$sql_con="SELECT a.tck1,a.tck2,a.bmx,a.bbjio,a.amex,a.univale,a.coppel,a.cc";
$sql_con.=",a.efe,a.tar,a.corte,a.tot_dia,a.created_date,s.marca,s.plaza,s.ciudad,a.id";
$sql_con.=" FROM av a,sucursales s WHERE a.id_suc=s.id AND s.id={$t} AND";
$sql_con.=" a.created_date BETWEEN '{$fs} 00:00:01' AND '{$ff} 23:59:59'";
$res_con=exec_query($sql_con);
$sql_t="SELECT * FROM sucursales WHERE id={$t}";
$res_t=exec_query($sql_t);
while($row=fetch($res_t)){
	$tienda=html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
}
$output=$tienda."<br>Del ".$fs." al ".$ff."<br>";
$output.="<table>
	<tr>
		<th>Fecha</th>
		<th>ID</th>
		<th>Inicial</th>
		<th>Final</th>
		<th>Banamex</th>
		<th>BanBajio</th>
		<th>American Express</th>
		<th>Efectivo</th>
		<th>Tarjetas</th>
		<th>Corte</th>
		<th>Venta del dia</th>
	</tr>";
while($row=fetch($res_con)){
	$id_t=$row["id"];
	$d=$row["created_date"];
	$output.="<tr><td>".date('m-d',strtotime($d))."</td>";
	$output.="<td>".$id_t."</td>";
	$output.="<td>".$row["tck1"]."</td>";
	$output.="<td>".$row["tck2"]."</td>";
	$output.="<td>$".$row["bmx"]."</td>";
	$output.="<td>$".$row["bbjio"]."</td>";
	$output.="<td>$".$row["amex"]."</td>";
	$output.="<td>$".$row["efe"]."</td>";
	$output.="<td>$".$row["tar"]."</td>";
	$output.="<td>$".$row["corte"]."</td>";
	$output.="<td class=\"total\"><strong>$".$row["tot_dia"]."</strong></td></tr>";
}
$output.="</table>";
$find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
$repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
$tienda=strtolower($tienda);
$tienda=str_replace($find,$repl,$tienda);
$tienda=str_replace(" ", "_",$tienda);
$filename="{$tienda}_{$fn_fs}/{$fn_ff}";
header('Content-Type:application/vnd.ms-excel');
header('Content-Disposition:attachment; filename="'.$filename.'".xls');
echo $output;
?>