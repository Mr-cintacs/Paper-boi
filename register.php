<?php 

include("database.php");

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
{
	session_start();
	$_SESSION = array();
	session_destroy();
}
$username=$password=$confirm_password=$type="";
$username_err=$password_err=$confirm_password_err="";

if($_SERVER['REQUEST_METHOD']=="POST")
{
	$type="student";
	//VALIDATE USERNAME
	if(empty(trim($_POST['username'])))
	{
		$username_err="*Please enter a username";
	}
	else
	{
		try {

			$query="select * from user where username = :username";
 			$stmt=$pdo->prepare($query);
 			$stmt->execute(["username"=>$_POST['username']]);
 			if($stmt->rowcount()==1)
 			{
 				$username_err="*This username is already taken";
 			}
 			else
 			{

 				$username=trim($_POST['username']);
 			}

		} catch (PDOException $e) {
			echo "problem while registering user";
		}
		
	}


	//VALIDATE PASSWORD
	if(empty(trim($_POST['password'])))
	{
		$password_err = "*Please enter a password";	
	}
	else
	{
		$password = trim($_POST['password']);
	}


	//VALIDATE CONFIRM PASSWORD
	if(empty(trim($_POST['confirm_password'])))
	{
		$password_err = "*Enter again";
		$confirm_password_err = "*Please enter a password";
	}
	elseif(empty($password_err) && $password!=$_POST['confirm_password'])
	{
		$password_err = "*Enter again";
		$confirm_password_err = "*Please enter the same password";
	}
	else
	{
		$confirm_password = trim($_POST['confirm_password']);
	}

	//CHECKING IF ALL ERRORS ARE EMPTY
	if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
	 		{
	 			$hash_password=password_hash($password, PASSWORD_DEFAULT);

	 			try {

	 				$query="insert into user(username,password,type) values(:username,:hash_password,:type)";

	 				$stmt=$pdo->prepare($query);
	 				if($stmt->execute(["username"=>$username,"hash_password"=>$hash_password,"type"=>$type]))
	 				{
	 					
	 					header('location: login.php');
	 				}
	 				else
	 				{
	 					echo "problem with record insertion";
	 				}
	 				
	 			} catch (PDOException $e) {
	 				echo "ERROR: --->".$e->getMessage();
	 			}
	 		}
}

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Register</title>
 	<link rel="stylesheet" href="css/register.css">
 </head>
 <body>
 	<nav class="navigation">
		<div class="logo">
			<img id="logo-img" src="images/exam.png" alt="image of paper/s">
			<h3 id="logo-text">PAPER PIMP</h3>
		</div>
		<ul id="list">
			<li> <a href="landing_page.php">HOME </a></li>
			<li> <a href="landing_page.php#login">LOGIN</a></li>
			<li> <a href="register.php"> REGISTER </a></li>
			<li> <a href="#"> ABOUT </a></li>
		</ul>
	</nav>

	<section id="register">

		<h1>Register</h1>
	 	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	 		<div>
	 			<label for="username">Enter Username</label>
		 		<input type="text" name="username" id="username">
		 		<span><?php echo $username_err ?></span>
	 		</div>
	 		<div>
	 			<label for="password">Enter Password</label>
		 		<input type="password" name="password" id="password">
		 		<span><?php echo $password_err ?></span>
	 		</div>
	 		<div>
	 			<label for="confirm_password">Confirm Password</label>
		 		<input type="password" name="confirm_password" id="confirm_password">
		 		<span><?php echo $confirm_password_err ?></span>
	 		</div>
	 		<button type="submit" name="submit" >Register</button>
	 	</form>
	</section>
 	
 </body>
 </html>