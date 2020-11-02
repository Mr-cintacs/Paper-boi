

<?php 

include("database.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		
	    $date = "";
	    $month_number = "";
	    $file_name = "";//FILE NAME FORMAT: QP-May-2019-converted.pdf
	    $subject_name = $subject_code = $month = $year="";
	    $subject_name_err = $subject_code_err = $month_err = $year_err=$record_not_found_err="";

	    //VALIDATE SUBJECT NAME
	    if(trim($_POST['subject_name'])=="select subject")
	    {
	        $subject_name_err = "*Please enter a subject name";
	    }
	    else
	    {
	        $subject_name = $_POST['subject_name'];
	    }
	    //VALIDATE SUBJECT CODE
	    if(trim($_POST['subject_code'])=="now select code" || (trim($_POST['subject_code'])=="Select subject name first"))
	    {
	        $subject_code_err = "*Please enter a subject code";
	    }
	    else
	    {
	        $subject_code = $_POST['subject_code'];
	    }
	    
	    //VALIDATE YEAR
	    if(empty(trim($_POST['date'])))
	    {
	        $year_err = "*Please select a year";
	    }
	    else
	    {
	        $month_year = $_POST['date'];
	        $file_name = "QP-".$month_year."-converted.pdf";
	        $arr = explode("-",$month_year);
	        $month = $arr[0];
	        $year = $arr[1];
	        ($month=="May")?$month="05":$month="12";
	        $date=$year."-".$month."-01";
	    }
	    
	    //CHECK IF ALL ERRORS AL EMPTY
	    if(empty($subject_name_err) && empty($subject_code_err) && empty($month_err) && empty($year_err))
	    {
	        
	        $values =array("subject_code"=>$subject_code,"date"=>$date);
	        try {
	        	$page_arr=array();
	            $query = "select page_no from papers where subject_code = :subject_code and date = :date";
	            $stmt = $pdo->prepare($query);
	            $stmt->execute($values);

	            if($stmt->rowcount()>0)
	            {
	            	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	            	{
	            		array_push($page_arr,$row['page_no']);
	            	}

	            	$passing_arr = array("page"=>$page_arr);
	            	$get_query = http_build_query($passing_arr);

	            	header("location:submit.php?".$get_query."&file_name=$file_name");
	            	
	            }
	            else{
	            	$record_not_found_err = "*There were no records found with that information try a different year";
	            }
	            

	        } catch (PDOException $e) {
	            echo "there was some error with getting the data ".$e->getMessage();
	        }
	    }
	}

 ?>