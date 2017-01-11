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
	return html_prep($row["marca"])." ".html_prep($row["plaza"])." ".html_prep($row["ciudad"]);
}
?>
