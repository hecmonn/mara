<?php
require_once("../includes/php_init.php");
class Proveedores{
    public $persona;
    public $nombre;
    public $apellido_materno;
    public $apellido_paterno;
    public $direccion;
    public $ciudad;
    public $pais;
    public $rfc;
    public $contacto;
    public $banco;
    public $cuenta;
    public $clabe;
    public $created_date;
    public $concepto;
    public $table="proveedores";
    public function create(){
        $attributes = self::prep_attributes();
        unset($attributes["table"]);
        $sql="INSERT INTO ".$this->table."(".join(",",array_keys($attributes)).")";
        $sql.=" VALUES('".join("','",array_values($attributes))."')";
        $res=exec_query($sql);
        return $res;
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
            $value_db=!empty($value)?mysql_prep(utf8_encode($value)):null;
            $cleaned_values[$key] = $value_db;
        }
        return $cleaned_values;
    }
    /*private function prep_values($values){
        $cleaned_values=[];+
        foreach($values as $val){
            $cleaned_values[]=mysql_prep($values);
        }
        return $cleaned_values;
    }*/
}
$Prov=new Proveedores();
?>
