<?php 

session_start();
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in']!=true)
{
	echo "you came back didn't you";
	header("location:index.php");
	exit;
}
include("database.php");

// $subject_names = "<option>select subject</option>";
// try {
// 	$query = "select distinct(subject_name) from papers";
// 	$stmt = $pdo->prepare($query);
// 	$stmt->execute();
// 	if($stmt->rowcount()>0)
// 	{
// 		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
// 		{
// 			$subject_names = $subject_names." <option value='$row[subject_name]'>$row[subject_name]</option> ";
// 		}
// 	}
	
// } catch (PDOException $e) {
// 	echo "ERROR:--->".$e->getMessage();
// }



 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Paper-Boi</title>
	<link rel="stylesheet" href="css/find_papers.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		
		$(document).ready(function()
		{
			$("#date").change(function()
			{
				if($(this).val() != "")
				{
					var action = $(this).attr("id");
					var date = $(this).val();
					var submit = "";
					$.post("get_names-codes.php",
						{
							action:action,
							submit:submit,
							date:date

						},function(data)
							{
								$("#sub_name").html(data);
							}
					);
				}

			});

			$("#sub_name").change(function()
			{
				if($(this).val() != "")
				{
					var action = $(this).attr("id");
					var sub_name = $(this).val();
					var date = $("#date").val();
					var submit   = "";

					$.post("get_names-codes.php",
					{
						action:action,
						submit:submit,
						sub_name:sub_name,
						date:date

					},function(data)
						{
							$("#sub_code").html(data);
						}
					);
				}

			});
		});
	</script>
</head>
<body>
	
	<nav class="navigation">
			<div class="logo">
				<img id="logo-img" src="images/exam.png" alt="image of paper/s">
				<h3 id="logo-text">PAPER BOI</h3>
			</div>
			<ul id="list">
				<li> <a class="nav-item" href="index.php">HOME </a></li>
				<li class="nav-item" id="user_info"> WELCOME :<span id='username'><?php echo ucfirst($_SESSION['username']) ;?></span></li>
				<li> <a class="nav-item" href="logout.php">LOGOUT</a></li>
			</ul>
		</nav>



	<section id="form">
		<h1>FIND PAPERS</h1>
		<form class='my-form' target="_blank" action="find_papers_submit.php" method="post" >
				<label for="date">Choose Month/Year :</label>
					<select name="date" id="date" >
						<option value=''>Pick a period</option>
						<option value="May-2019">MAY '19</option>
						<option value="May-2018">MAY '18</option>
						<option value="May-2017">MAY '17</option>
						<option value="May-2016">MAY '16</option>
						<option value="Dec-2018">DEC '18</option>
						<option value="Dec-2017">DEC '17</option>
						<option value="Dec-2016">DEC '16</option>
					</select>

				<label for="sub_name">subject name:</label>
				<select name="subject_name" id="sub_name">
					<option>Select date first</option>
				</select>
				<span id="error"><?php echo $subject_name_err ?></span>
				
				<label for="sub_code">subject code:</label>
				<select name="subject_code" id="sub_code">
					<option>Select subject name first</option>
				</select>
				<span id='error'><?php echo $subject_code_err ?></span>

				<div class="year_and_btn">
					<input id="btn" type="submit" name="submit_form" value="Get Paper">
				</div>
				
		</form>
		<span id='error'><?php echo $record_not_found_err ; ?></span>	
	</section>
	<footer>
			 <p>A site to see by <span>Pavit Kailay</span></p>
	</footer>
		

</body>
</html>