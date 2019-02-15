<?php
require '../php/Php.php';
require '../dbh/dbh.php';

if(isset($_POST['Project_id']) && isset($_POST['Stage'])){

	
	$Staff_id = 'SIST19';
	$Project_id = $_POST['Project_id'];
	$Stage = $_POST['Stage'];
	//Lock_key ensures that a lecturer assess a project only once by locking his/ her marks with it.
	$Lock_key = $Staff_id."lock".$Stage.$Project_id;
	$i = 0;
	#echo $Lock_key;
	
	while (!empty($_POST['mark'.$i]) || !empty($_POST['select'.$i]) || !empty($_POST['item'.$i]))
	{
		$mark = $_POST['mark'.$i];
		$comment = $_POST['option'.$i];
		$Item_id = $_POST['item'.$i];
		$sql = "SELECT * FROM assessment_marks WHERE Lock_key = '$Lock_key'";
		$result = mysqli_query($Conn,$sql);
  		$confirm = mysqli_num_rows($result);
   		if ($confirm >0 )
   		{	
   			echo "Sorry you already assessed the project"."<br>" ."PAGE INTERFACE DISABLED DUE TO SESSION VARIABLES NOT WORKING PROPERLY"."<br>";
   			break;
   		}
   		else{
   			$sql = "INSERT INTO assessment_marks (Staff_id, Project_id,Assessment_id,Item_id,Mark,Comment) VALUES ('$Staff_id','$Project_id','$Stage',$Item_id,$mark,'$comment')";
		if ($Conn->query($sql) === False){
			 echo "Error: " . $sql ."panooooo". "<br>" . $Conn->error;
		}
		$i = $i +1;
   		}
   	}
   	$sql= "UPDATE assessment_marks SET Lock_key = '$Lock_key' WHERE Project_id = '$Project_id' AND Assessment_id = '$Stage' AND Staff_id = '$Staff_id'";
   	if ($Conn->query($sql) === False){

			 echo "Error: " . $sql ."panapa"."<br>" . $Conn->error;
		}else{
			average($Staff_id,$Stage,$Project_id);
		}

		//header("location: ../pages/assessment.php");
		
}else{
	echo "Error: " . $sql ."panapa"."<br>" . $Conn->error;

}