<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php 

$a = new DateTime();
$date = $a->format('Y-m-d H:i:s');
echo $date;

 if ($a instanceof DateTime) {
 	echo "it's a date";
 }
 else{
 	echo "Not an integer";
 }
?>

