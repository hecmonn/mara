<?php
require_once("../includes/php_init.php");

$metas=metas();
$title="Metas";
require_once("../includes/header.php");
?>
<div class="container">
    <div class="row">
        <?php echo $metas; ?>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
