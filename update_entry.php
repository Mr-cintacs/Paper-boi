<?php  

$id = isset($_GET['id'])?$_GET['id']:die("there was some problem while getting the id");
echo "$id";
require_once('database.php');

try {
	$query = "select * from papers where paper_id = :id";
	$stmt = $pdo->prepare($query);
	$stmt->execute(["id"=>$id]);

	if($stmt->rowcount()>0)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$sub_name_value = $row['subject_name'];
		$sub_code_value = $row['subject_code'];
		$page_no_value = $row['page_no'];
	}
	else{
		die("ERROR:".$e->getMessage());
	}

} catch (PDOException $e) {
	echo "ERROR:".$e->getMessage();
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
	$subject_name = trim($_POST['subject_name']);
	$subject_code = trim($_POST['subject_code']);
	$page_no 	  =	$_POST['page_no'];
	
	try {
		$values = array("id"=>$id, "subject_code"=>$subject_code, "subject_name"=>$subject_name ,"page_no"=>$page_no);
		$query = "update papers set subject_code=:subject_code, subject_name=:subject_name ,page_no=:page_no where paper_id = :id";
		$stmt = $pdo->prepare($query);

		if($stmt->execute($values))
		{
			echo nl2br(" \n \n \n updation of record successful");
		}
	} catch (PDOException $e) {
		echo "there was some problem with updating the records ".$e->getMessage();
	}	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>update entry</title>
</head>
<body>
	<h2>Update entries</h2>
	<br>
	<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?id=$id"; ?>' method="post">
		<label for="subject_name">Enter subject name :</label>
		<textarea type="texta" name="subject_name" id="subject_name"><?php  echo $sub_name_value ?>
		</textarea> 
		<label for="subject_code">Enter subject code</label>
		<input type="text" name="subject_code" id="subject_code" value="<?php echo $sub_code_value ?>">
		<label for="page">Page number</label>
		<input type="number" name="page_no" id="page" value="<?php echo $page_no_value ?>">
		<input type="submit" value="submit" name="submit">
		<a href="data_show.php">back to data show</a>
	</form>
</body>
</html>