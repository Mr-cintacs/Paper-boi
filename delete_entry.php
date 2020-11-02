<?php 

require_once('database.php');
$id = isset($_GET['id'])?$_GET['id']:die("there was some problem while getting the id");

try {
	$values = array("id"=>$id);
	$query = "delete from papers where paper_id = :id";
	$stmt = $pdo->prepare($query);

	if($stmt->execute($values))
	{
		header('location:data_show.php');
	}
} catch (PDOException $e) {
	echo "there was some problem with deleting the records ".$e->getMessage();
}


 ?>