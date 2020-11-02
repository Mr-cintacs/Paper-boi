<?php 

include('database.php');

if(isset($_POST['submit']))
{

	
	$sub_name = $_POST['sub_name']."%";
	$sub_code = $_POST['sub_code'];
	$date = (string)$_POST['dates'];

	$field1 = $field2 = $field3 = "";
	$condition="";
	$where_stmt = array();
	$values = array();

	if(!empty($_POST['sub_name']))
	{
		
		$field1 = " subject_name like :sub_name ";
		array_push($where_stmt,$field1);
		$values["sub_name"] = $sub_name;

	}
   	if(!empty($_POST['sub_code']))
	{
		
		$field2 =" subject_code = :sub_code ";
		array_push($where_stmt,$field2);
		$values["sub_code"] = $sub_code;

	}
	if(!empty($_POST['dates']))
	{		
		$field3 = " date =:date ";
		array_push($where_stmt,$field3);
		$values["date"] = $date;
	}
	if(count($where_stmt)==3)
	{
		$where_stmt[1]= "and".$where_stmt[1];
		$where_stmt[2]= "and".$where_stmt[2];
	}
	if(count($where_stmt)==2)
	{
		$where_stmt[1]= "and".$where_stmt[1];
	}

	foreach($where_stmt as $whole)
	{
		$condition = $condition.$whole;
	}

	try {

		$query = "select * from papers where $condition";
		$stmt = $pdo->prepare($query);
		$stmt->execute($values);
		if($stmt->rowcount()>0)
		{
			echo "<div class = 'tablebox'>";
				echo"<table class='mytable'>";
					echo "<thead>";
						echo"<tr>";
							echo "<th>Subject Name</th>";
							echo "<th>Subject Code</th>";
							echo "<th>Page No</th>";
							echo "<th>Date</th>";
							echo "<th>Action</th>";
						echo"</tr>";
					echo"<thead>";

			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				echo "<tbody>";
					echo"<tr>";
					echo "<td>$row[subject_name]</td>";
					echo "<td>$row[subject_code]</td>";
					echo "<td>$row[page_no]</td>";
					echo "<td>$row[date]</td>";
					echo "<td>";
						echo "<a href='update_entry.php?id=".$row['paper_id']."'> update </a>";
						echo "<a href='delete_entry.php?id=".$row['paper_id']."'> delete </a>";
					echo "</td>";
					echo"</tr>";
				echo "<tbody>";
			}
			echo "</div>";
	}
	else{
		echo "there where no records found";
	}

	} catch (PDOException $e) {
		echo "there was some problem with displaying the data".$e->getMessage();
	}

}

 ?>