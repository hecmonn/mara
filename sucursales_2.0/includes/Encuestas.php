<?php
require_once("php_init.php");
require_once("DbObj.php");
class Encuestas extends DbObjects{
    public $frecuencia;
    public $formas_pago;
    public $metodo_pago;
    public $servicio;
    public $encontro;
    public $nombre;
    public $edad;
    public $correo;
    public $telefono;
    public $razon;
    public $sid;
    public $table="encuestas";
}
$Encuestas=new Encuestas();
?>
