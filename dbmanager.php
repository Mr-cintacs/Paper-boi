<?php 

include('database.php');
// try {

// 	$query = "select * from papers";
// 	$stmt = $pdo->prepare($query);
// 	$stmt->execute();
// 	if($stmt->rowcount()>0)
// 	{
// 			echo"<table class='mytable'>";
// 				echo "<thead>";
// 					echo"<tr>";
// 						echo "<th>Subject Name</th>";
// 						echo "<th>Subject Code</th>";
// 						echo "<th>Page No</th>";
// 						echo "<th>Date</th>";
// 					echo"</tr>";
// 				echo"<thead>";

// 		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
// 		{
// 			echo "<tbody>";
// 				echo"<tr>";
// 				echo "<td>$row[subject_name]</td>";
// 				echo "<td>$row[subject_code]</td>";
// 				echo "<td>$row[page_no]</td>";
// 				echo "<td>$row[date]</td>";
// 				echo "<td>";
// 					echo "<a href='update_entry.php?id=".$row['paper_id']."' target='_blank'> update </a>";
// 					echo "<a href='delete_entry.php?id=".$row['paper_id']."'> delete </a>";
// 				echo "</td>";
// 				echo"</tr>";
// 			echo "<tbody>";
			
// 		}
		
// 	}
// 	else{
// 		echo "there where no records found";
// 	}

// } catch (PDOException $e) {
// 	echo "there was some problem with displaying the data".$e->getMessage();
// }
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>show entries</title>
 	<link rel="stylesheet" href="css/data_show.css">
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 	<script>
 		$(document).ready(function()
 			{
 				$("#btn").on("click",function(event)
 				{
 					event.preventDefault();
 					var sub_name = $("#sub_name").val();
 					var sub_code = $("#sub_code").val();
 					var dates = $("#dates").val();
 					var submit = $("#btn").val();

 					$(".mytable").load("data_show_submit.php",{

 						sub_name:sub_name,
 						sub_code:sub_code,
 						dates:dates,
 						submit:submit
 					});
 				});
 			});
 	</script>
 </head>
 <body>
 	<div class='heading'>
 		<h1>Search Database:</h1>
 	</div>
 	

 	<form id="myform" action="data_show_submit.php" method ="post">

 		<label for="sub_name">Subject name :</label>
 		<input type="text" name="sub_name"  id="sub_name">

 		<label for="sub_code">Subject code :</label>
 		<input type="text" name="sub_code" id="sub_code">

 		<label for="dates">Date :</label>
 		<select name="dates" id="dates">
 			<option value="2019-05-01">MAY 2019</option>
 			<option value="2018-05-01">MAY 2018</option>
 			<option value="2017-05-01">MAY 2017</option>
 			<option value="2016-05-01">MAY 2016</option>
 			<option value="2019-12-01">DEC 2019</option>
 			<option value="2018-12-01">DEC 2018</option>
 			<option value="2017-12-01">DEC 2017</option>
 			<option value="2016-12-01">DEC 2016</option>
 		</select>

 		<button id="btn" name="submit">Search</button>
 	</form>

 	<div class="mytable">
 		
 	</div>
 </body>
 </html>