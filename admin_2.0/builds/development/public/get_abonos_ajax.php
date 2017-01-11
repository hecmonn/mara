<?php
require_once("../includes/php_init.php");
$q = intval($_GET['i']);
$sql="SELECT * FROM abonos WHERE id_ad = '".$q."'";
$res=exec_query($sql);
$output="";
while($row = fetch($res)) {
    $output.= "<tr><td>".$row['cantidad']."</td>";
    $output.= "<td>".$row['created_date']."</td></tr>";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table class="table table-striped">
	<tr>
		<th>Cantidad</th>
		<th>Fecha</th>
	</tr>
	<?php echo $output; ?>
</table>
</body>
</html>