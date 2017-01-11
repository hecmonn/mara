<?php
class Database{
	private $server;
	private $user;
	private $password;
	private $database;
	public $con;

	public function __construct(){
		$this->connect();
	}
	public function connect(){
		/*define("DB_SERVER", "localhost");
		define("DB_USER", "grupom13_admin");
		define("DB_PASS", "5r9AVnR+R#c)");
		define("DB", "grupom13_mara_production");*/
		define("DB_SERVER", "localhost");
		define("DB_USER", "root");
		define("DB_PASS", "admin");
		define("DB", "gpomara");
		$this->con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB);
		if(mysqli_errno($this->con)){
			die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_error().")");
		}
	}
}
$Database = new Database();
 ?>
