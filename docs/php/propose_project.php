<?php
require '../dbh/dbh.php';

$sql = "SELECT Proposed_date FROM assessment_details WHERE Department = 'Software Engineering' AND Status = 'current'";
$result = mysqli_query($Conn,$sql);
$confirm = mysqli_num_rows($result);

if ($confirm > 0) {
	
	while ($row = mysqli_fetch_assoc($result)) {
		$date1 = $row['Proposed_date'];
	}

     $date2 = date("Y-m-d");    
	$date1 = new DateTime($date1);
	$date2 = new DateTime($date2);
     
    
	$interval = date_diff($date1, $date2);
	$num =  $interval->format('%R%a');

	if ($num <0) {
		session_start();
		$_SESSION['deadline'] = $num;
		header('location: ../pages/message.php');
	}

}
else{
	echo "Error: ". $sql . "<br>" . $Conn->error;
}/*

if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['field']) && !empty($_POST['tools']) && !empty(['year']) && !empty(['course']))
{
	

	$title			 = $_POST['title'];
	$description 	 = $_POST['description'];
	$attachment		 = $_POST['attachment'];
	$field			 = $_POST['field'];
	$tools 			 = $_POST['tools'];
	$year 			 = $_POST['year'];
	$Level			 = $_POST['course'];
	$Department      = "Software Engineering";
	$Reg_number  	 = 'h170272g';

	$sql = "SELECT * FROM projects WHERE Department = '$Department'";
	$result = mysqli_query($Conn,$sql);
    $confirm = mysqli_num_rows($result);

    $Project_id = 'SE'.$confirm ;

	$sql = "INSERT INTO projects (Project_id,Year,Level,Project_title,Project_description,Field,Department,Stage,Tools)VALUES ('$Project_id','$year','$Level','$title','$description','$field','$Department','current','$tools')";
	
	  if ($Conn->query($sql) === TRUE)
          {

          	$target_dir = "../files/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            //check if  file is already there
            if (file_exists($target_file))
            {
    				echo "Sorry, file already exists.";
    				$uploadOk = 0;
			}

			// Check file size
			if ($_FILES["file"]["size"] > 5000000)
			{
    				echo "Sorry, your file is too large.";
    				$uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) 
			{
    				echo "Sorry, your file was not uploaded.";
    				$filename = basename($_FILES['file']['name']);
        				$filepath = $target_dir.$filename;
        				$sql = "INSERT INTO projects_files(Project_id,File_name,File_description,File_path) VALUES ('$Project_id','$filename','$attachment','$filepath')";
        				if ($Conn->query($sql) === TRUE)
          					{
          						$sql = "INSERT INTO project_developers(Project_id,Reg_number) VALUES ('$Project_id','$Reg_number')";
          						if ($Conn->query($sql) === TRUE)
          							{
          								header('location: ../pages/student_portal.php');
          							}else{
          								echo "Developing Error: " . $sql . "<br>" . $Conn->error;
          							}

          					}else{
          						echo "Upload Error: " . $sql . "<br>" . $Conn->error;
          					}
					// if everything is ok, try to upload file
			} else {
    				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
    				{
        				echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
        				$filename = basename($_FILES['file']['name']);
        				$filepath = $target_dir.$filename;
        				$sql = "INSERT INTO projects_files(Project_id,File_name,File_description,File_path) VALUES ('$Project_id','$filename','$attachment','$filepath')";
        				if ($Conn->query($sql) === TRUE)
          					{
          						$sql = "INSERT INTO project_developers(Project_id,Reg_number) VALUES ('$Project_id','$Reg_number')";
          						if ($Conn->query($sql) === TRUE)
          							{
          								header('location: ../pages/student_portal.php');
          							}else{
          								echo "Developing Error: " . $sql . "<br>" . $Conn->error;
          							}

          					}else{
          						echo "Upload Error: " . $sql . "<br>" . $Conn->error;
          					}

    				} else {
        					echo "Sorry, there was an error uploading your file.";
    						}
					}
                                  #header("location: ../pages/student_portal.php");
                                     
          }
            else{
                  echo "system Error: " . $sql . "<br>" . $Conn->error;
                }
}
*/