<?php
function mysql_prep($string){
	global $Database;
	$encoded_string = utf8_decode($string);
	return mysqli_real_escape_string($Database->con, $encoded_string);
}

function exec_query($sql){
	global $Database;
	$result_set= mysqli_query($Database->con, $sql);
	if(!$result_set){
		die("Query failed: ".mysqli_error($Database->con));
	}
	return $result_set;
}

function fetch($res){
	return mysqli_fetch_assoc($res);
}

function redirect_to($location){
	header("Location:".$location);
	exit;
}

function html_prep($string){
	return htmlentities(ucfirst(utf8_encode($string)));
}

function quincena($sd=0){
	$daten=date("d");
	$md = cal_days_in_month(CAL_GREGORIAN, date("m"), date("y"));
	$y=date("Y",time());
	$m=date("m",time());
	if($daten>15){
		$fecha=date("Y-m-d",strtotime("last day of this month"));
		$days_ago=date("Y-m-d",mktime(0,0,0,$m,16,$y));
		$wd=$md-15;
		$sb=$sd*$wd;
	}
	else{
		$fecha=date("Y-m-d",mktime(0,0,0,$m,15,$y));
		$days_ago = date('Y-m-d', strtotime('-14 days', strtotime($fecha)));
		$sb=$sd*15;
	}
	$fortnight=[$fecha,$days_ago,$sb];
	return $fortnight;
}
function get_past_quincena($date){
	$cleaned_date=date("Y-m-d",strtotime($date));

}

function get_fecha($quin){
	$no_days=$quin*15;
	$date = new DateTime();
	$y="2016";
	$wn=floor($no_days/7);
	$date->setISODate($y,$wn);
	$cdate=$date->format('Y-M-d');
	return $cdate;
}
function find_username($attempting_user,$table){
	$cleaned_user=mysql_prep($attempting_user);
	$sql_us="SELECT * FROM {$table} WHERE usuario='{$cleaned_user}'";
	$res_us=exec_query($sql_us);
	if($user=fetch($res_us)){
		return $user;
	}
	else{return null;}
}
function attempt_login($tempt_username, $password, $table){
	$attempting_user = find_username($tempt_username,$table);
		if($attempting_user){
			if(password_verify($password, $attempting_user["password"])){
				return $attempting_user;
			} else {
				return false;
			}
		} else {
			return false;
		}
}

function count_rec($table){
		$sql_tr = "SELECT COUNT(*) from {$table}";
		$res_set = exec_query($sql_tr);
		$row = mysqli_fetch_array($res_set);
		return array_shift($row);
}
function tienda($row){
	return html_prep($row["marca"])." ".html_prep($row["plaza"])." ".utf8_encode($row["ciudad"]);
}
function day($convert_day){
	$day=date("Y-m-d",strtotime($convert_day));
	$bd=date("Y-m-01",strtotime("today"));
	$bd.=" 00:00:59";
	$ed=$day." 23:59:59";
	return [$bd,$ed];
}

function money($how_much){
	return number_format($how_much,2,'.',',');
}
function std_date($date){
	return date("F d Y",strtotime($date));
}
//imprime las estadisiticas de la meta en el mes actual
function metas(){
	$curr_month=date("m",strtotime("today"));
	$days_till_now=date("d",strtotime("today"));
	$cy=date("Y",strtotime("today"));
	$dm=cal_days_in_month(CAL_GREGORIAN, $curr_month, $cy);
	$day=day("today");
	$sql_suc="SELECT * FROM sucursales";
	$res_suc=exec_query($sql_suc);
	$output="";
	while ($row=fetch($res_suc)) {
		$sid=$row["id"];
		$tienda=tienda($row);
		$sql_meta="SELECT meta FROM metas WHERE id_suc={$sid} AND month(created_date)={$curr_month}";
		$sql_av="SELECT sum(tot_dia) as 'tot' FROM av WHERE id_suc={$sid} AND created_date BETWEEN '{$day[0]}' AND '{$day[1]}'";
		$res_meta=exec_query($sql_meta);
		$res_av=exec_query($sql_av);
		while ($row_meta=fetch($res_meta)) {
			$meta_temp=$row_meta["meta"];
		}
		while ($row_av=fetch($res_av)) {
			$curr_vt_temp=$row_av["tot"];
		}
		$meta=is_null($meta_temp)?1:($meta_temp);
		$meta_disp=money($meta);
		$curr_vt=is_null($curr_vt_temp)?1:($curr_vt_temp);
		$curr_vt_disp=money($curr_vt);
		$pre=money(($curr_vt*100)/$meta);
		$meta_diaria=$meta/$dm;
		$ideal=($meta_diaria*$days_till_now);
		$pideal=money(($ideal*100)/$meta);
		$ideal_disp=money($ideal);
		$pid=money((($ideal*100)/$meta));
		$output.="<div class='col-md-6'><h3>{$tienda}</h3><div class='row'><div class='col-md-6'>";
		$output.="<strong>Meta actual:</strong><p>{$meta_disp} MXN</p><strong>Vendido hasta hoy:</strong><p>{$curr_vt_disp} MXN</p><strong>Venta ideal:</strong><p>{$ideal_disp} MXN</p>";
		$output.="</div><div class='col-md-6'><strong>Porcentaje actual:</strong> <p>{$pre}%</p><strong>Porcentaje ideal:</strong><p> {$pideal}%</p></div></div></div>";
	}
	return $output;
}

function show_tiendas(){
	$sql="SELECT * FROM sucursales WHERE plaza NOT LIKE '%Oficina%'";
	$res=exec_query($sql);
	$output=[];
	while ($row=fetch($res)) {
		$output[]= tienda($row);
	}
	return $output;
}

function get_metas_por(){
	$curr_month=date("m",strtotime("today"));
	$days_till_now=date("d",strtotime("today"));
	$cy=date("Y",strtotime("today"));
	$dm=cal_days_in_month(CAL_GREGORIAN, $curr_month, $cy);
	$day=day("today");
	$sql_suc="SELECT * FROM sucursales WHERE plaza NOT LIKE '%Oficina%'";
	$res_suc=exec_query($sql_suc);
	$output="";
	while ($row= fetch($res_suc)) {
		$sid=$row["id"];
		$tienda=tienda($row);
		$sql_meta="SELECT meta FROM metas WHERE id_suc={$sid} AND month(created_date)={$curr_month}";
		$sql_av="SELECT sum(tot_dia) as 'tot' FROM av WHERE id_suc={$sid} AND created_date BETWEEN '{$day[0]}' AND '{$day[1]}'";
		$res_meta=exec_query($sql_meta);
		$res_av=exec_query($sql_av);

		$meta=mysqli_num_rows($res_meta)>0?array_shift(fetch($res_meta)):1;
		$meta_disp=money($meta);
		$curr_vt=mysqli_num_rows($res_av)>0?array_shift(fetch($res_av)):1;
		$curr_vt_disp=money($curr_vt);
		$pre=money(($curr_vt*100)/$meta);
		$meta_diaria=$meta/$dm;
		$ideal=($meta_diaria*$days_till_now);
		$ideal_disp=money($ideal);
		$pid=money((($ideal*100)/$meta));
		$porcentajes[]=$pre;
	}
	return $porcentajes;
}

function formas_pago(){
	$curr_month=date("m",strtotime("today"));
	$days_till_now=date("d",strtotime("today"));
	$cy=date("Y",strtotime("today"));
	$dm=cal_days_in_month(CAL_GREGORIAN, $curr_month, $cy);
	$day=day("today");
	$sql_suc="SELECT * FROM sucursales";
	$res_suc=exec_query($sql_suc);
	$output="";
	$bv=0;
	$univale=0;
	$coppel=0;
	$efe=0;
	$tar=0;
	while ($row=fetch($res_suc)) {
		$sid=$row["id"];
		$sql_fp="SELECT coppel,univale,cc,efe,tar FROM av WHERE id_suc={$sid} AND created_date BETWEEN '{$day[0]}' AND '{$day[1]}'";
		$res_fp=exec_query($sql_fp);
		while ($row_fp=fetch($res_fp)) {
			$bv+=(float)$row_fp["cc"];
			$univale+=(float)$row_fp["univale"];
			$coppel+=(float)$row_fp["coppel"];
			$efe+=(float)$row_fp["efe"];
			$tar+=(float)$row_fp["tar"];
		}
		$fp_arr=[$bv,$univale,$coppel,$efe,$tar];
		foreach ($fp_arr as $key=>$value) {
			$fp_arr[$key]=str_replace(",",".",$value);

		}
	}
	return $fp_arr;
}
function now(){
	return date("Y-m-d",strtotime("today"));
}


?>
