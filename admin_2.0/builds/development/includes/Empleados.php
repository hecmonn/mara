<?php
require_once("../includes/Database.php");
require_once("../includes/functions.php");
class Empleados{
	protected $table="empleados";
	public $nombre;
	public $telefono;
	public $curp;
	public $imss;
	public $f_nam;
	public $sexo;
	public $estado;
	public $direccion;
	public $f_ing;
	public $f_sal;
	public $puesto;
	public $sueldo;

	public function create(){
		$attributes = self::prep_attributes();
		$sql="INSERT INTO ".$this->table."(".join(",",array_keys($attributes)).")";
		$sql.=" VALUES('".join("','",array_values($attributes))."')";
		return $sql;
	}

	public function update(){
		$attributes=self::prep_attributes();
		$sql="UPDATE ".$this->table."(".join(",",array_keys($attri));
	}

	private function get_attributes(){
		return get_object_vars($this);
	}
	private function prep_attributes(){
		$attributes = $this->get_attributes();
		$cleaned_values = [];
		foreach($attributes as $key => $value){
			$cleaned_values[$key] = mysql_prep($value);
		}
		return $cleaned_values;
	}
	public function show_adeudos($id_e=0){
		//get monto total
		$sql_tot="SELECT sum(cantidad) FROM adeudos WHERE id_em={$id_e}";
		$res_tot=exec_query($sql_tot);
		$cant_tot=fetch($res_tot);
		//get adeudos
		$output="";
		$sql_a="SELECT * FROM adeudos where id_em={$id_e} AND cantidad>0";
		$res_a=exec_query($sql_a);
		while($row=fetch($res_a)){
			$output.="<td><a href=\"#\" id=\"$id\">".html_prep($row["descr"])."</td>";
			$output.="<td>".money_format('%i', $row["cantidad"])."</td>";
			$output.="<td>".strftime('%d %B %G', strtotime($row["created_date"]))."</td></tr>";
		} 
		return $output;
	}
	
}
$Empleados = new Empleados();
?>