
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Document</title>
 </head>
 <body>
 	
 	<form  target="_blank" action="test_submit.php"  method="post" >
 		<input type="text">
 		<input type="submit" value="submit to new page">
 	</form>
 	<?php 
 	include("database.php");
 	try {
 			$date = "2019-05-01";
 			$sub_name = "APPLIED PHYSICS-I";
			$query = "select distinct(subject_code) from papers where date =:date and subject_name =:sub_name ";
			$stmt = $pdo->prepare($query);
			$stmt->execute([ 'date'=>$date,'sub_name'=>$sub_name]);
			if($stmt->rowcount()>0)
			{
				echo"<table class='mytable'>";
					echo "<thead>";
						echo"<tr>";
							echo "<th>Subject Code</th>";
							echo "<th>Date</th>";
						echo"</tr>";
					echo"<thead>";
				while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					//$subject_codes = $subject_codes." <option value='$row[subject_code]'>$row[subject_code]</option>";
					echo "<tbody>";
					echo"<tr>";					
					echo "<td>$row[subject_code]</td>";					
					echo "<td>$row[date]</td>";
					echo"</tr>";
				echo "<tbody>";
				}
				echo "</table>";
			}
		
		} catch (PDOException $e) {
			echo "ERROR:--->".$e->getMessage();
		}
 	 ?>
	

 </body>
 </html>