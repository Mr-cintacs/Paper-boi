<?php 

session_start();

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
{
	header("location: find_papers.php");
	exit;
}
include("database.php");

if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$flag=true;
	$username=$password=$type="";
	$type_err=$username_err=$password_err="";

		//VALIDATE USERNMAE
		if(empty(trim($_POST['username'])))
		{
			$username_err="please enter an username";
		}
		else{
			$username=trim($_POST['username']);
		}

		//VALIDATE PASSWORD
		if(empty(trim($_POST['password'])))
		{
			$password_err="please enter a password";
		}
		elseif(strlen($_POST['password'])<=8)
		{
			$password_err="enter a password with more than 8 characters";
		}
		else
		{
			$password=trim($_POST['password']);
		}
		//VALIDATE TYPE
		if(empty(trim($_POST['type'])))
		{
			$type_err="please enter an username";
		}
		else{
			$type=trim($_POST['type']);
		}

		if(empty($username_err) && empty($password_err) && empty($type_err))
		{
			try {
				//CHANGE TABLE NAME
				$query="select * from user where username = :username";
				$stmt=$pdo->prepare($query);
				$stmt->execute(["username"=>$username]);

				if($stmt->rowcount()==1)
				{
					if($row=$stmt->fetch())
					{
						$id=$row['u_id'];
						$username=$row['username'];
						$hashed_password=$row['password'];
						$returned_type=$row['type'];

						if($returned_type!=$type)
						{
							$type_err = "You have selected the wrong user type";
							$flag = false;
						}

						if(password_verify($password, $hashed_password))
						{
							if($flag==true)
							{
								echo "Logged In";
								session_start();
								$_SESSION['logged_in']=true;
								$_SESSION['id']=$id;
								$_SESSION['username']=$username;

								if($type == "student")
								{
									header('location: find_papers.php');
								}
								if($type == "MASTER")
								{
									header('location: data_show.php');
								}
							}
							
						}
						else
						{
							$password_err=" You entered the wrong password";
						}
					}
				}
				else
				{
					$username_err="No account found with that username";
				}		
				
			} catch (PDOException $e) {
				echo "ERROR:---->".$e->getMessage();
			}
			
		}

}

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>📄 Paper-Boi </title>
	<link rel="stylesheet" href="css/landing_page.css">
</head>
<body>

	<div class="container">
		<nav class="navigation">
			<div class="logo">
				<img id="logo-img" src="images/exam.png" alt="image of paper/s">
				<h3 id="logo-text">PAPER PIMP</h3>
			</div>
			<ul id="list">
				<li> <a class='nav-item' href="#home">HOME </a></li>
				<li> <a class='nav-item' href="#login">LOGIN</a></li>
				<li> <a class='nav-item' href="register.php"> REGISTER </a></li>
				<li> <a class='nav-item' href="#"> ABOUT </a></li>
			</ul>
		</nav>

		<section id="home">
			<h1>welcome</h1>
			<p>A simple tool to help my college students save time by searching for and grouping question papers for them.</p>
			<button id="btn"><a href="#login">Login To Get Started</a></button>
		</section>

		<section id="login">
			
			<h1>LOGIN</h1>
			<form action="landing_page.php?#login" method="post">
				<div id="user-pass">
					<label for="username">Enter Username</label>
			 		<input id="username" type="text" name="username">
			 		<span><?php echo $username_err ;?></span>

			 		<label for="password">Enter Password</label>
			 		<input id="password" type="password" name="password">
			 		<span><?php echo $password_err ; ?></span>
				</div>
		 		
				<div id="type-submit">
					<label for="type">Select user type</label>
			 		<select name="type" id="type">
			 			<option value="student">Student</option>
			 			<option value="MASTER">MASTER</option>
			 		</select>
			 		<span><?php echo $type_err ; ?></span>

			 		<input id="btn" type="submit" name="submit" value="Log In">	
			 		<span>Don't have an account ? <a href="register.php"> Register</a></span>	
				</div>
		 </form>
		 <footer>
			 <p>A site to see by <span>Pavit Kailay</span></p>
		 </footer>
		</section>

	</div>
	<!-- <footer>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></footer> -->
</body>
</html>
bb321b70fac802:945b8e45@us-cdbr-east-02.cleardb.com/heroku_5218d42c02c031e
jigglysmackeronney86