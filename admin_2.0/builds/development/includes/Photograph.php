<?php
define("PHOTO_PATH","../files/empleados/");
class Photograph{
	public $filename;
	private $type;
	private $size;
	public $path=PHOTO_PATH;
	private $tmp_path;
	public $error;
	private $ext;

	public function attach_file($file){
		$this->validate_photo($file);
		$this->filename=$file["name"];
		$this->type=$file["type"];
		$this->size=$file["size"];
		$this->tmp_path=$file["tmp_name"];
		$this->error=$file["error"];
	}

	public function save_photo($id){
		$id_e = $id;
		$this->filename=$id_e.$this->ext;
		if($this->error != 0){
			$_SESSION["message"]="Seleccionar foto";
			redirect_to("../public/nuevo_empleado.php");
		}
		$this->path.=$this->filename;
		if(file_exists($this->path)){
			$time=time();
			$this->filename.="_{$time}";
		}
		if(move_uploaded_file($this->tmp_path, $this->path)){
			$rel_path="/admin/files/empleados/".$this->filename;
			return $rel_path;
		}
		else { die($this->path);
			return false; }
	}
	private function validate_photo($file){
		if($file['type'] == "image/png"){
				$this->ext = ".png";
		}
		elseif($file['type'] == "image/jpg"){
				$this->ext = ".jpg";
		}
		elseif($file['type'] == "image/jpeg"){
				$this->ext= ".jpg";
		}
		elseif($file['type'] == "image/gif"){
				$this->ext=".gif";
		}
		elseif($file['type'] == "image/bmp"){
				$this->ext=".bmp";
		}
	}
}
$Photograph = new Photograph();
?>