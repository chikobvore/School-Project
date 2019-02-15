
<?php
 require '../dbh/dbh.php';

if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['reg_number']) &&  isset($_POST['physical_address']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['dob']) && isset($_POST['Gender']) && isset($_POST['program']))
          {
            $name         = $_POST['name'];
            $surname      = $_POST['surname'];
            $reg_number   = $_POST['reg_number'];
            $paddress     = $_POST['physical_address'];
            $email        = $_POST['email'];
            $phone        = $_POST['phone'];
            $dob          = $_POST['dob'];
            $Gender       = $_POST['Gender'];
            $program      = $_POST['program'];

          $sql = "INSERT INTO students (Name,Surname,Reg_number,Program,Department,Email_address,Physical_address,Contact,Gender,DOB) VALUES('$name','$surname','$reg_number','$program','$program','$email','$paddress','$phone','$Gender','$dob')";

          if ($Conn->query($sql) === TRUE) {
                                     header("location: ../pages/home.php");
                              }
                              else{
                               # header("location: ../pages/error.html");
                                    echo "Error: " . $sql . "<br>" . $Conn->error;
                              }
    }else{
    
}

?>