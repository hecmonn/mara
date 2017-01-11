<?php
session_start();
function session_message() {
	if(isset($_SESSION["message"])){
		$output="<div class=\"session_message\" style=\"width:100%; border:1px solid rgba(0,0,0,.5)\"><h4 class=\"text-center\">";
		$output.=htmlentities($_SESSION["message"]);
		$output.="</h4></div>";
		$_SESSION["message"]=null;
		return $output;
	}
}
?>
