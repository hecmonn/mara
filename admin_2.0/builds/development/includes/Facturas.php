<?php
require_once("../includes/php_init.php");

class Facturas{
    public $folio;
    public $created_date;
    public $vencimiento;
    public $cantidad;
    public $id_prov;
    public $id_rs;
    private $table="facturas";

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
            $cleaned_values[$key] = mysql_prep($value);
        }
        return $cleaned_values;
    }
    //facturas
    public function facturas_vencidas(){
    	$now=now();
    	$sql="SELECT f.cantidad,f.folio,p.nombre,f.id,f.vencimiento FROM facturas f,proveedores p WHERE vencimiento<='{$now}'";
        $sql.=" AND p.id=f.id_prov ORDER BY f.vencimiento";
    	$res=exec_query($sql);
        return $res;
    }
    public function facturas_por_vencer(){
    	$vencimiento=date("Y-m-d",strtotime("today + 5 days"));
        $today=now();
    	$sql="SELECT f.cantidad,f.folio,p.nombre,f.vencimiento,f.id FROM proveedores p JOIN facturas f ON f.id_prov=p.id AND vencimiento BETWEEN '{$today} 00:00:01' AND '{$vencimiento} :23:59:59'";
        $sql.=" ORDER BY f.vencimiento";
    	$res=exec_query($sql);
        return $res;
    }
    public function pagos($folio){
        $sql="SELECT * FROM pagos WHERE id_fac={$folio}";
        $res=exec_query($sql);
        return $res;
    }
    public function cantidad_restante($fid){
        $sql="SELECT cantidad FROM facturas WHERE id={$fid}";
        $res=exec_query($sql);
        $monto=(float)array_shift(fetch($res));
        $sql_pagos="SELECT sum(pago) FROM pagos WHERE id_fac={$fid}";
        $res_pagos=exec_query($sql_pagos);
        $pagos=(float)array_shift(fetch($res_pagos));
        $restante=money($monto-$pagos);
        return $restante;
    }
    public function vigente($vencimiento){
        $ven=strtotime($vencimiento);
        $now=strtotime("today");
        return $ven>$now;
    }
    public function estado($fid,$vigencia){
        $restante=$this->cantidad_restante($fid)>0;
        if($restante){
            if($vigencia){
                $estado="Vigente";
            } else{
                $estado="Vencida";
            }
        } else{
            $estado="Pagada";
        }
        return $estado;
    }
}
$Facturas=new Facturas();

?>
