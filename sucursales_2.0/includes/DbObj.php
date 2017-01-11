<?php
class DbObjects{
	public function create(){
		unset($_POST["submit"]);
		unset($_POST["descr"]);
		unset($_POST["cantidad"]);
		$cleaned_val=$this->prep_attributes($_POST);
		$sql_create="INSERT INTO {$this->table} (".join(",",array_keys($cleaned_val));
		$sql_create.=") VALUES ('".join("','",array_values($cleaned_val))."')";

		$res_create=exec_query($sql_create);
		return $res_create;
	}
	private function prep_attributes($att){
		$cleaned_att=[];
		foreach($att as $key => $value){
			$upd_val=empty($value)?0:$value;
			$cleaned_att[$key]= mysql_prep($upd_val);
		}
		return $cleaned_att;
	}
}
?>
