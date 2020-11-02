<?php 

include("database.php");
if(isset($_POST['submit']))
{


	if($_POST['action'] == "date")
	{
		$subject_names = "<option> now select subject</option>";
		
		//EXTRACT DATE FROM $_POST['date']
		 $month_year = $_POST['date'];
        $arr = explode("-",$month_year);
        $month = $arr[0];
        $year = $arr[1];
        ($month=="May")?$month="05":$month="12";
        $date=$year."-".$month."-01";

		$value = array("date"=>$date);
		try {
			$query = "select distinct(subject_name) from papers where date =:date order by subject_name";
			$stmt = $pdo->prepare($query);
			$stmt->execute($value);
			if($stmt->rowcount()>0)
			{
				while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$subject_names = $subject_names." <option value='$row[subject_name]'>$row[subject_name]</option> ";
				}
			}

		} catch (PDOException $e) {
			echo "ERROR------>".$e->getMessage();
		}

		echo $subject_names;//RETURNS DATE TO AJAX POST METHOD
	}

	if($_POST['action'] == "sub_name")
	{
		$subject_codes = "<option> now select code </option>";
		$sub_name = $_POST['sub_name'];

		//EXTRACT DATE FROM $_POST['date']

		$month_year = $_POST['date'];
        $arr = explode("-",$month_year);
        $month = $arr[0];
        $year = $arr[1];
        ($month=="May")?$month="05":$month="12";
        $date=$year."-".$month."-01";
		//$value = array("date"=>$date,"sub_name"=>$sub_name);

		try {

			$query = "select distinct(subject_code) from papers where date =:date and subject_name =:sub_name";
			$stmt = $pdo->prepare($query);
			$stmt->execute([ 'date'=>$date,'sub_name'=>$sub_name]);
			if($stmt->rowcount()>0)
			{
				while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$subject_codes = $subject_codes."<option value='$row[subject_code]'>$row[subject_code]</option>";
				}
			}
		
		} catch (PDOException $e) {
			echo "ERROR:--->".$e->getMessage();
		}

		echo $subject_codes;//RETURNS DATA TO AJAX POST METHOD
	}
	
}


 ?>