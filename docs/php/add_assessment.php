<?php
 require '../dbh/dbh.php';

 
if(isset($_POST['title']) && isset($_POST['course']) && isset($_POST['input1']) && isset($_POST['input2'])&& isset($_POST['period']) && isset($_POST['field']) && isset($_POST['objectives']) && isset($_POST['assessment_date']))

{
              session_start();
              
            $Department = $_SESSION['Department'];
            $titlename = $_POST['title'];
            $course     =$_POST['course'];
            $n1        = $_POST['input1'];
            $n2        = $_POST['input2'];
            $n3        = $_POST['input3'];
            $n4        = $_POST['input4'];
            $n5        = $_POST['input5'];
            $n6        = $_POST['input6'];
            $n7        = $_POST['input7'];
            $n8        = $_POST['input8'];
            $n9        = $_POST['input9'];
            $n10       = $_POST['input10'];
            $Period    = $_POST['period'];
            $date   = $_POST['assessment_date'];
            $objectives   = $_POST['objectives'];
            $status = "PENDING";

           $title = $titlename;
           $lockkey = $titlename.$course.$Period;

            $sql = "INSERT INTO assessment_details (Year,Department,Level,Status,Assessment_title,Proposed_date,Assessment_objectives, Assessment_lockkey) VALUES ('$Period','$Department','$course','$status','$title','$date','$objectives','$lockkey')";

            if ($Conn->query($sql) === TRUE)
            {
              
                $inputs = array($n1,$n2,$n3, $n4,$n5);
                $numbers = array($n6,$n7,$n8,$n9,$n10);
                $sql ="SELECT Assessment_id FROM assessment_details WHERE Department ='$Department' AND Level ='$course' AND Assessment_title='$title'";
                $result = mysqli_query($Conn,$sql);
                $confirm = mysqli_num_rows($result);

                     if ($confirm>0)
                      {
                        while ($row = mysqli_fetch_assoc($result))
                        {
                          $id = $row['Assessment_id'];
                        }
                        
                          for ($i=0; $i <5 ; $i++)
                          { 

                            if (!empty($inputs[$i]))
                            {
                            $sql = "INSERT INTO assessment_items (Assessment_id,Item,Item_mark) VALUES ($id,'$inputs[$i]',$numbers[$i])"; 
                            if ($Conn->query($sql) === FALSE)
                            {
                                   echo "Error: " . $sql . "<br>" . $Conn->error; 
                            }
                          } 
                        }
                        header("location: ../pages/department.php");
              }  
            else
              {
              echo "Error: " . $sql . "<br>" . $Conn->error;
                }
  }else
  {
    echo "system Error: ". "something is not set" . $Conn->error;
  }
}else
  {
    echo "ERROR: ". "something is not set" . $Conn->error;
    echo $_POST['period'].$_POST['stage'].$_POST['assessment_date'].$_POST['title'].$_POST['date'].$_POST['objectives'];
  }

      

         
                   


  