<?php
function assessments()
{
   require '../dbh/dbh.php';
   $sql = "SELECT Assessment_id,Level,Department,Year,Assessment_title FROM assessment_details where Status = 'current'";

   $result = mysqli_query($Conn,$sql);
   $confirm = mysqli_num_rows($result);
   if ($confirm > 0) {
     if ($confirm < 2) {
       while ($rows = mysqli_fetch_assoc($result)){
        $id = $rows['Assessment_id'];
        $Stage = $rows['Assessment_title'];
        $Level = $rows['Level'];
         $sql = "SELECT Item,Item_mark,Item_id FROM Assessment_items WHERE Assessment_id = $id";
         $result = mysqli_query($Conn,$sql);
         $confirm = mysqli_num_rows($result);

         if ($confirm > 0)
          echo "<div class='row'>".
                      "<div class='col-lg-12'>".
                        "<header class='panel-heading'>".
                        "<label class='control-label'>"."Date: "."</label>"."<p style='display: inline;'>"."09/12/2018"."</p>"."<br>"
                        ."<label>"."Assessment: "."<input type='text' name='Stage' readonly='' placeholder='$Stage' style='border: none;  background-color: inherit;' value = '$id'>".$Stage."<br>".
                        "<label>"."Department: "."</label>"."<p style='display: inline;'>".$rows['Department']."</p>"."<br>".
                        "<label>"."Period: "."</label>"."<p style='display: inline;'>".$rows['Year']."</p>"."<br>"."<br>".
                        "<center>".
                        "<button class='btn btn-success'>"."Set as Assessed"."<button>".
                        "<button class='btn btn-success'>"."Revert"."<button>".
                        "</center>".
                      "</header>".
                      "</div>".
                    "</div>".
                    "<hr>";
          project($Level);
          echo "<table class='table table-hover'>".
                "<tbody>".
                  "<tr class='row'>".
                    "<th class='col-lg-3'>"."Item"."</th>".
                    "<th class='col-lg-3'>"."Mark"."</th>".
                    "<th class='col-lg-3'>"."Out of"."</th>".
                    "<th class='col-lg-3'>"."comment"."</th>".
                  "</tr>";
          {
            $i = 0;
           while ($row = mysqli_fetch_assoc($result)) {
            $name = 'mark'.$i;
            $select = 'option'.$i;
            $number = $row['Item_mark'];
            $Item_id = $row['Item_id'];
            $item = 'item'.$i;
            echo 
                  "<tr class='row'>".
                    "<td class='col-lg-3'>".$row['Item']."</td>".
                    "<td class='col-lg-3'>"."<input type='number' name = $name class='form-control' max = $number required = ''>"."</td>".
                    "<td class='col-lg-3'>"."</label>"."<input type='number' name= '$item' readonly='' placeholder='$number' style='border: none;  background-color: inherit; visibility: Hidden;' value = $Item_id >".$number."</label>"."</td>".

                    //"<label class='control-label' name = 'Item_id'>".$row['Item_mark']."</label>"."</td>".
                    "<td class='col-lg-3'>".
                      "<select class='form-control' name = $select>".
                      "<option value='Very Bad'>"."Very Bad"."</option>".
                      "<option value= 'Bad'>"."Bad"."</option>".
                      "<option value = 'Good'>"."Good"."</option>".
                      "<option value='Better'>"."Better"."</option>".
                      "<option value = 'Execellent'>"."Execellent"."</option>".
                    "</select>"."</td>".
                  "</tr>";
              $i = $i +1;
           }
           echo "</tbody>".
              "</table>"."<div class='form-group'>".
                        "<hr>".
                        "<label>"."<h3>"."Overall comment"."</h3>"."</label>".
                        "<textarea class='form-control' name='comment' required=''>".
                          
                        "</textarea>".
                        "<br>".
                        "<center>".
                        "<div>".
                          "<button type='reset' class='btn btn-primary'>"."Prev"."</button>".
                          "<button type='submit'class='btn btn-success'>"."Submit"."</button>".
                          "<button type='reset' class='btn btn-default'>"."Next"."</button>".
                        "</div>".
                      "</center>".
                      "</div>";
         }
       }    
     }
   }else
   {
   echo "<div class='row'>".
            "<div class='col-lg-12'>".
              "<center>".
              "<h3 class='page-header'>"."You have no Scheduled Presentation Today"."</h3>".
            "<p>"."You will be automatically redirected to to presentation once set"."</p>".
          "</center>".
            "</div>".
            "</div>";
  }
}
function project($level)
{
   require '../dbh/dbh.php';
   $sql = "SELECT DISTINCT Project_title,Project_id FROM projects WHERE Level = '$level'";
   $result = mysqli_query($Conn,$sql);
   $confirm = mysqli_num_rows($result);
   if ($confirm >0 ) {
    echo "<div class='row'>".
                      "<div class='col-lg-12'>".
                        "<section class='panel'>".
                          "<header class='panel-heading'>"."<label class='control-label'>"."Select Project"."</label>".
                            "<select class='form-control' name='Project_id' required = ''>";
    while ($row = mysqli_fetch_assoc($result)){
      $id = $row['Project_id'];
    echo "<option value = $id>".
                  "<h3>".$row['Project_title']."</h3>".
                      "</option>";
   }
   echo "</select>".
                    "</header>".
                          "<br>";
}
else
{
  echo "<div class='row'>".
                      "<div class='col-lg-12'>".
                        "<section class='panel'>".
                          "<header class='panel-heading'>".
                          "<h4>"."No projects found to assess"."<br>"."Please add projects"."</h4>".
                           "<br>" . $Conn->error.
                           "<br>".
                          "</header>".
                          "<br>";
}
}
function Sidebar($role)
{
	/* This function is responsible for dynamic side bar displaying of all pages. 
	*/

	if ($role == 'co-ordinator') {

    echo "<ul class='app-menu'>".
        "<li>"."<a class='app-menu__item active' href='department.php'>"."<i class='app-menu__icon fa fa-dashboard'>"."</i>"."<span class='app-menu__label'>"."Home"."</span>"."</a>"."</li>".
       "<li class='treeview'>"."<a class='app-menu__item' href='#'' data-toggle='treeview'>"."<i class='app-menu__icon fa fa-edit'>"."</i>"."<span class='app-menu__label'>"."New"."</span>"."<i class='treeview-indicator fa fa-angle-right'>"."</i>"."</a>".

          "<ul class='treeview-menu'>".
            "<li>"."<a class='treeview-item' href='#student_modal' data-toggle='modal'>"."<i class='icon fa fa-users'>"."</i>"."Supervisor"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='#lecture_modal' data-toggle='modal'>"."<i class='icon fa fa-user'>"."</i>"."Group"."</a>"."</li>".
          "</ul>".
        "</li>".
       
        "<li>"."<a class='app-menu__item' href='../../src/SIST/sist/_page_id_54_wordpress.html'>"."<i class='app-menu__icon fa fa-users'>"."</i>"."<span class='app-menu__label'>"."Guests"."</span>"."</a>"."</li>".
         "<li>"."<a class='app-menu__item' href='Assessment_projects.php''>"."<i class='app-menu__icon fa fa-file-text'>"."</i>"."<span class='app-menu__label'>"."Assess projects"."</span>"."</a>"."</li>".
        "<li class='treeview'>"."<a class='app-menu__item' href='#'' data-toggle='treeview'>"."<i class='app-menu__icon fa fa-edit'>"."</i>"."<span class='app-menu__label'>"."Projects"."</span>"."<i class='treeview-indicator fa fa-angle-right'>"."</i>"."</a>".

          "<ul class='treeview-menu'>".
            "<li>"."<a class='treeview-item' href='projects.php''>"."<i class='app-menu__icon fa fa-file-text'>"."</i>"."Hit200"."</a>"."</li>"."<li>"."<a class='treeview-item' href='projects.php''>"."<i class='app-menu__icon fa fa-file-text'>"."</i>"."Hit400"."</a>"."</li>".
            "<li>"."<a class='treeview-item' data-toggle='modal' href='#myModal5'>"."<i class='icon fa fa-circle-o'>"."</i>"."New"."</a>"."</li>".
          "</ul>".
        "</li>".
        "<li class='treeview'>"."<a class='app-menu__item' href='#'' data-toggle='treeview'>"."<i class='app-menu__icon fa fa-th-list'>"."</i>"."<span class='app-menu__label'>"."View"."</span>"."<i class='treeview-indicator fa fa-angle-right'>"."</i>"."</a>".
          "<ul class='treeview-menu'>".
            "<li>"."<a class='treeview-item' href='students.php'>"."<i class='icon fa fa-circle-o'>"."</i>"."Students"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='lectures.php''>"."<i class='icon fa fa-circle-o'>"."</i>"."Staff"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='marks.php''>"."<i class='icon fa fa-circle-o'>"."</i>"."Marks"."</a>"."</li>".
          "</ul>".
        "</li>".
        "<li class='treeview'><a class='app-menu__item' href='#' data-toggle='treeview'>"."<i class='app-menu__icon fa fa-file-text'>"."</i>"."<span class='app-menu__label'>"."More"."</span>"."<i class='treeview-indicator fa fa-angle-right'>"."</i>"."</a>".
          "<ul class='treeview-menu'>".
            "<li>"."<a class='treeview-item' href='blank-page.html'>"."<i class='icon fa fa-circle-o'>"."</i>"."Blank Page"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='page-login.html'>"."<i class='icon fa fa-circle-o'>"."</i>"."Login Page"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='page-calendar.html'>"."<i class='icon fa fa-circle-o'>"."</i>"." Calendar Page"."</a>"."</li>".
            ".<li>"."<a class='treeview-item' href='page-mailbox.html'>"."<i class='icon fa fa-circle-o'>"."</i>"." Mailbox"."</a>"."</li>".
            
          "</ul>".
        "</li>".
      "</ul>";
	}
  if ($role == 'student') {
        echo "<ul class='app-menu'>".
        "<li>"."<a class='app-menu__item active' href='student_portal.php'>"."<i class='app-menu__icon fa fa-dashboard'>"."</i>"."<span class='app-menu__label'>"."Home"."</span>"."</a>"."</li>".
       
        "<li class='treeview'>"."<a class='app-menu__item' href='#'' data-toggle='treeview'>"."<i class='app-menu__icon fa fa-file-text'>"."</i>"."<span class='app-menu__label'>"."Propose Project"."</span>"."<i class='treeview-indicator fa fa-angle-right'>"."</i>"."</a>".
          "<ul class='treeview-menu'>".
            "<li>"."<a class='treeview-item' data-toggle='modal' href='#mod9'>"."<i class='icon fa fa-circle-o'>"."</i>"."New Project"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='page-login.html'>"."<i class='icon fa fa-circle-o'>"."</i>"."Enter a Group"."</a>"."</li>".
          "</ul>".
        "</li>".
    
         "<li>"."<a class='app-menu__item' href='#'>"."<i class='app-menu__icon fa fa-user'>"."</i>"."<span class='app-menu__label'>"."Supervisor"."</span>"."</a>"."</li>".
        "<li>"."<a class='app-menu__item' href='projects.php'>"."<i class='app-menu__icon fa fa-edit'>"."</i>"."<span class='app-menu__label'>"."View Projects"."</span>"."</a>"."</li>".
        "<li>"."<a class='app-menu__item' href='#'>"."<i class='app-menu__icon fa fa-calendar'>"."</i>"."<span class='app-menu__label'>"."School calender"."</span>"."</a>"."</li>".

        "<li class='treeview'><a class='app-menu__item' href='#' data-toggle='treeview'>"."<i class='app-menu__icon fa fa-file-text'>"."</i>"."<span class='app-menu__label'>"."More"."</span>"."<i class='treeview-indicator fa fa-angle-right'>"."</i>"."</a>".
          "<ul class='treeview-menu'>".
            "<li>"."<a class='treeview-item' href='blank-page.html'>"."<i class='icon fa fa-circle-o'>"."</i>"."Blank Page"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='page-login.html'>"."<i class='icon fa fa-circle-o'>"."</i>"."Login Page"."</a>"."</li>".
            "<li>"."<a class='treeview-item' href='page-calendar.html'>"."<i class='icon fa fa-circle-o'>"."</i>"." Calendar Page"."</a>"."</li>".
            ".<li>"."<a class='treeview-item' href='page-mailbox.html'>"."<i class='icon fa fa-circle-o'>"."</i>"." Mailbox"."</a>"."</li>".
            
          "</ul>".
        "</li>".
      "</ul>";
  }
}
function assessment_details($Department)
{
    require '../dbh/dbh.php';
   $sql = "SELECT Assessment_id,Status, Assessment_title,Level,Year,Proposed_date,Assessment_objectives FROM assessment_details WHERE Department = '$Department'";
   $result = mysqli_query($Conn,$sql);
   $confirm = mysqli_num_rows($result);
   if ($confirm >0 )
   {
    echo "<div class='row'>".
            "<div class='col-md-12'>".
              "<div class='tile'>".
                "<div class='tile-body'>".
                  "<table class='table table-hover table-bordered' id='sampleTable'>".
                    "<thead>".
                        "<tr>".
                          "<th>"."Title"."</th>".
                          "<th>"."Level"."</th>".
                          "<th>"."Year"."</th>".
                          "<th>"."Description"."</th>".
                          "<th>"."Proposed date"."</th>".
                          "<th>"."Status"."</th>".
                          "<th>"."Items"."</th>".
                          "<th>"."Action"."</th>".
                        "<tr>".
                      "</thead>".
                      "<tbody>";
        while ($row = mysqli_fetch_assoc($result))
        {
         echo "<tr>".
                "<td>".$row['Assessment_title']."</td>".
                "<td>".$row['Level']."</td>".
                "<td>".$row['Year']."</td>".
                "<td>".$row['Assessment_objectives']."</td>".
                "<td>".$row['Proposed_date']."</td>".
                "<td>".$row['Status']."</td>";
                items($row['Assessment_id']);
        echo    "<td>"."<button type='submit' class='btn btn-primary'>"."Edit"."</button>".
                      "<button type='submit' class='btn btn-danger' onclick='<?php '>"."Delete"."</button>".
                                                                                              "</td>".
              "</tr>";
        }
            echo "</tbody>".
                "</table>".
               "</div>".
              "</div>".
            "</div>".
          "</div>";
   } 
}
function items($id)
{
  require '../dbh/dbh.php';
   $sql = "SELECT item FROM Assessment_items WHERE Assessment_id = $id";
   $result = mysqli_query($Conn,$sql);
   $confirm = mysqli_num_rows($result);
   if ($confirm >0 )
   {    
    echo "<td>";
        while ($row = mysqli_fetch_assoc($result))
        {
            echo $row['item']." ,";
        }
        echo "</td>";
    }
    else{
      echo "<td>"."No items set"."</td>";
    }
}
function projects($Department)
{
   require '../dbh/dbh.php';
   $sql = "SELECT Year,Level,Project_title,Project_description,Department,Supervisor,Stage,Field FROM Projects WHERE Department = '$Department'";
   $result = mysqli_query($Conn,$sql);
   $confirm = mysqli_num_rows($result);
   if ($confirm >0 )
   {
    echo "<div class='col-md-12'>".
                    "<div class='tile'>".
                      "<div class='tile-body'>".
                        "<table class='table table-hover table-bordered' id='sampleTable'>".
                          "<thead>".
                                "<tr>".
                                  "<th>"."Title"."</th>".
                                  "<th>"."Description"."</th>".
                                  "<th>"."Year"."</th>".
                                  "<th>"."Level"."</th>".
                                  "<th>"."Field of Study"."</th>".
                                  "<th>"."Supervisor"."</th>".
                                  "<th>"."Status"."</th>".
                                  "<th>"."Level of Success"."</th>".
                                  "<th>"."Action"."</th>".
                                "</tr>".
                          "</thead>".
                          "<tbody>";
        while ($row = mysqli_fetch_assoc($result))
        {
              echo "<tr>".
                    "<td>".$row['Project_title']."</td>".
                    "<td>".$row['Project_description']."</td>".
                    "<td>".$row['Year']."</td>".
                    "<td>".$row['Level']."</td>".
                    "<td>".$row['Field']."</td>".
                    "<td>".$row['Supervisor']."</td>".
                    "<td>".$row['Stage']."</td>".
                    "<td>"."<div class='progress mb-2'>".
                              "<div class='progress-bar bg-success' role='progressbar' style='width: 80%;' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100'>"."</div>".
                          "</div>"."</td>".
                    "<td>".
                      "<div class='btn-group'>".
                        "<ion-icon name='link'>"."</ion-icon>".
                        "<a class='btn btn-primary' href='#'>"."<i class='fa fa-thumbs-o-up'>"."8"."</i>"."</a>".
                        "<a class='btn btn-success' href='#'>"."<i class='fa fa-comment'>"."3"."</i>"."</a>".
                        "<a class='btn btn-danger'  href='files/result.pdf'>"."<i class='fa fa-download'>"."</i>"."</a>".
                      "</div>".
                  "</tr>";
        }
            echo "</tbody>".
              "</table>".
            "</div>".
          "</div>".
          "</div>";
    }else{
      echo "No students projects found. Please add Projects";
    }
    
} 
function lectures($Department)
{
   require '../dbh/dbh.php';
   $sql = "SELECT Title,Name,Surname,Gender,Email_address,Contact FROM lecturers WHERE Department = '$Department'";
   $result = mysqli_query($Conn,$sql);
   $confirm = mysqli_num_rows($result);
   if ($confirm >0 )
   {
    echo "<div class='col-md-12'>".
                    "<div class='tile'>".
                      "<div class='tile-body'>".
                        "<table class='table table-hover table-bordered' id='sampleTable'>".
                          "<thead>".
                                "<tr>".
                                  "<th>"."Title"."</th>".
                                  "<th>"."Name"."</th>".
                                  "<th>"."Surname"."</th>".
                                  "<th>"."Gender"."</th>".
                                  "<th>"."Email_address"."</th>".
                                  "<th>"."Contact"."</th>".
                                "</tr>".
                          "</thead>".
                          "<tbody>";
        while ($row = mysqli_fetch_assoc($result))
        {
              echo "<tr>".
                    "<td>".$row['Title']."</td>".
                    "<td>".$row['Name']."</td>".
                    "<td>".$row['Surname']."</td>".
                    "<td>".$row['Gender']."</td>".
                    "<td>".$row['Email_address']."</td>".
                    "<td>".$row['Contact']."</td>".
                  "</tr>";
        }
            echo "</tbody>".
              "</table>".
            "</div>".
          "</div>".
          "</div>";
    }else{
      echo $sql."<br>".$Conn->error;
    }
    
} 
function students($Department)
{
   require '../dbh/dbh.php';
   $sql = "SELECT Name,Surname,Reg_number,Gender,Email_address,Contact FROM students WHERE Department = '$Department'";
   $result = mysqli_query($Conn,$sql);
   $confirm = mysqli_num_rows($result);
   if ($confirm >0 )
   {
    echo "<div class='col-md-12'>".
                    "<div class='tile'>".
                      "<div class='tile-body'>".
                        "<table class='table table-hover table-bordered' id='sampleTable'>".
                          "<thead>".
                                "<tr>".
                                  "<th>"."Name"."</th>".
                                  "<th>"."Surname"."</th>".
                                  "<th>"."Reg_number"."</th>".
                                  "<th>"."Gender"."</th>".
                                  "<th>"."Email_address"."</th>".
                                  "<th>"."Contact"."</th>".
                                "</tr>".
                          "</thead>".
                          "<tbody>";
        while ($row = mysqli_fetch_assoc($result))
        {
              echo "<tr>".
                    "<td>".$row['Name']."</td>".
                    "<td>".$row['Surname']."</td>".
                    "<td>".$row['Reg_number']."</td>".
                    "<td>".$row['Gender']."</td>".
                    "<td>".$row['Email_address']."</td>".
                    "<td>".$row['Contact']."</td>".
                  "</tr>";
        }
            echo "</tbody>".
              "</table>".
            "</div>".
          "</div>".
          "</div>";
    }else{
      echo $sql."<br>".$Conn->error;
    }
    
}
function average($Staff_id,$stage,$Project_id,$comment)
{
  require '../dbh/dbh.php';
      $Staff_id = $Staff_id;
      $Lock_key = $Staff_id."lock".$stage.$Project_id;
      $p_id = $Project_id;
      $A_id = $stage;
     
      $sql = "SELECT DISTINCT SUM(Mark) FROM assessment_marks WHERE Lock_key = '$Lock_key'";
       $result = mysqli_query($Conn,$sql);
       $confirm = mysqli_num_rows($result);
       if ($confirm >0 )
        {
       while ($row = mysqli_fetch_assoc($result))
        {
          $AVG = $row['SUM(Mark)'];
        }
      }
      else{
        echo "INSERTION: " . $sql . "<br>" . $Conn->error;
      }
        $sql = "SELECT SUM(Item_mark) FROM Assessment_items where Assessment_id = '$stage'";
       $result = mysqli_query($Conn,$sql);
       $confirm = mysqli_num_rows($result);
       if ($confirm >0 ) {
       while ($row = mysqli_fetch_assoc($result))
        {
          $SUM = $row['SUM(Item_mark)'];
        }
      }
      $Total = ($AVG/$SUM)*100;
      $Mark_id = $Staff_id.'lock'.$p_id.'id'.$A_id;
      $sql = "INSERT INTO lecturer_assessment_marks(Staff_id, Project_id,Assessment_id,Mark_id,Mark,Total_mark,Overal_mark,comment) VALUES ('$Staff_id','$p_id',$A_id,'$Mark_id', '$AVG', $SUM,$Total)";
      if ($Conn->query($sql) === TRUE){
        mark_total($p_id,$A_id,$SUM,$Total);
      }else{
          echo "INSERTION yyy Error: " . $sql . "<br>" . $Conn->error . $AVG;
          
        }

      }
      function mark_total($Project_id,$Assessment_id,$SUM,$Total)
      {
        require '../dbh/dbh.php';

          $sql ="SELECT * FROM lecturer_assessment_marks WHERE Project_id ='$Project_id' AND Assessment_id = $Assessment_id";
       $result = mysqli_query($Conn,$sql);
       $num = mysqli_num_rows($result);
       

        $sql ="SELECT AVG(Overal_mark), AVG(Mark) FROM lecturer_assessment_marks WHERE Project_id ='$Project_id' AND Assessment_id = $Assessment_id";
       $result = mysqli_query($Conn,$sql);
       $confirm = mysqli_num_rows($result);
       if ($confirm >0 )
       {
           while ($row = mysqli_fetch_assoc($result))
                {
                      $avg = $row['AVG(Overal_mark)'];
                      $mark = $row['AVG(Mark)'];
                }
                $sql = "INSERT INTO final_mark (Project_id,Assessment_id,Mark,Total_mark,Overal_mark,Assessed_by) VALUES('$Project_id','$Assessment_id',$mark,$SUM,$avg,$num)";
                if ($Conn->query($sql) === TRUE)
                    {
                      header('location: ../pages/assessment_projects.php');
                     }else{
                      $sql = "UPDATE final_mark  SET Overal_mark = $avg ,Assessed_by =$num,Mark=$mark WHERE Project_id ='$Project_id' AND Assessment_id = '$Assessment_id'";
                       if ($Conn->query($sql) === TRUE)
                            {
                                header('location: ../pages/Assessment.php');
                              }else{
                                echo "Error".$sql . "<br>" . $Conn->error;

                              }
                     }
       }
      }
function stages($Department)
{
  require '../dbh/dbh.php';
  $sql = "SELECT Assessment_lockkey,Assessment_title,Level,Status FROM assessment_details WHERE Department = '$Department'";
  $result = mysqli_query($Conn,$sql);
  $confirm = mysqli_num_rows($result);

  if ($confirm >0 )
       {
        echo
         "<div class='col-md-6'>".
          "<div class='tile'>".
            "<h4>"."<i>"."Department Assessment"."</i>"."</h4>".
            "<form method ='POST' Action = '#'>".
            "<table class='table table-striped'>".
              "<thead>".
              "<tr>".
              "<th>"."Assessment title"."</th>".
              "<th>"."Level"."</th>".
              "<th>"."Status"."</th>".
              "<th>"."Tick to assess"."</th>".
            "</tr>".
          "</thead>"."<tbody>";
              while ($row = mysqli_fetch_assoc($result))
                {
                  if ($row['Status'] == 'Assessed') {

                     echo "<tr>".
                        "<td>".$row['Assessment_title']."</td>".
                        "<td>".$row['Level']."</td>".
                        "<td>".$row['Status']."</td>".
                        "<td>"."<div class='toggle-flip'>".
                         "<label>".
                          "Assessed".
                          "</label>".
                          "</div>"."</td>"."</tr>";
                  }
                  elseif ($row['Status'] == 'current'){
                    $value = $row['Assessment_lockkey'];
                   echo "<tr>".
                        "<td>".$row['Assessment_title']."</td>".
                        "<td>".$row['Level']."</td>".
                        "<td>".$row['Status']."</td>".
                        "<td>"."<div class='toggle-flip'>".
                         "<label>".
                          "current".
                          "</label>".
                          "</div>"."</td>"."</tr>";
                }else{
                  $value = $row['Assessment_lockkey'];
                   echo "<tr>".
                        "<td>".$row['Assessment_title']."</td>".
                        "<td>".$row['Level']."</td>".
                        "<td>".$row['Status']."</td>".
                        "<td>"."<div class='toggle-flip'>".
                         "<label>".
                          "<input type='radio' name='assess' value = $value>".
                          "</label>".
                          "</div>"."</td>"."</tr>";
                }
              }
                echo "</table>".
                    "<center>".
            "<button type='submit' class='btn btn-primary' id='demoSwal'>"."Save changes"."</button>".
          "</center>".
          "</form>".
          "</div>";
     }
}
function displayfiles($Department)
{
  require '../dbh/dbh.php';

  $sql ="SELECT Project_id, Project_title,Project_description,Level,Year FROM projects WHERE Department ='$Department'";
  $result = mysqli_query($Conn,$sql);
  $confirm = mysqli_num_rows($result);

  if ($confirm >0 )
       {
         while ($row = mysqli_fetch_assoc($result))
         {
          $Project_id = $row['Project_id'];
          echo  "<tr>".
                  "<td>".$row['Project_title']."</td>".
                  "<td>".$row['Project_description']."</td>".
                  "<td>".$row['Year']."</td>".
                  "<td>".$row['Level']."</td>";
                  Developer($Project_id);
                  Files($Project_id);
              echo "</tr>";

         }
       }
}
function Developer($Project_id)
{
  require '../dbh/dbh.php';
  $sql = "SELECT Reg_number FROM project_developers WHERE Project_id = '$Project_id'";
  $result = mysqli_query($Conn,$sql);
  $confirm = mysqli_num_rows($result);

  if ($confirm > 0) {
    while ($row = mysqli_fetch_assoc($result))
    {
      $Reg_number = $row['Reg_number'];
      $sql = "SELECT Name,Surname FROM students WHERE Reg_number = '$Reg_number'";
      $result = mysqli_query($Conn,$sql);
      $confirm = mysqli_num_rows($result);
      if ($confirm > 0)
      {
        echo "<td>";
        while ($row = mysqli_fetch_assoc($result))
        {
          echo $row['Name']." ".$row['Surname'].",";
        }
        echo "</td>";
      }

    }
  }

}
function Files($Project_id)
{
  require '../dbh/dbh.php';
  $sql = "SELECT File_description,File_path,File_name FROM projects_files WHERE Project_id = '$Project_id'";
  $result = mysqli_query($Conn,$sql);
  $confirm = mysqli_num_rows($result);

  if ($confirm > 0) {
    echo "<td>";
    while ($row = mysqli_fetch_assoc($result))
    {
      $path = $row['File_path'];
      echo "<a href='$path'>".$row['File_description']."</a>";
    }
    echo "</td>";
  }else{
    echo "<td>"."No files attached"."</td>";
              ;
  }
  
}
function marks()
{
  require '../dbh/dbh.php';

  $sql = "SELECT * FROM final_mark";
  $result = mysqli_query($Conn,$sql);
  $confirm = mysqli_num_rows($result);

  if ($confirm > 0)
  {
    while ($row = mysqli_fetch_assoc($result))
    {
      $Project_id = $row['Project_id'];
      $Assessment_id = $row['Assessment_id'];
      $mark = $row['Overal_mark'];
      display1($Project_id,$Assessment_id);
    }
  }
}
function display1($Project_id,$Assessment_id)
{
  require '../dbh/dbh.php';

      $sql = "SELECT Reg_number FROM project_developers WHERE Project_id = '$Project_id'";
      $result = mysqli_query($Conn,$sql);
      $confirm = mysqli_num_rows($result);

      if ($confirm > 0)
        {

            while ($row = mysqli_fetch_assoc($result))
            {
              $Reg_number = $row['Reg_number'] ;
              display2($Reg_number,$Assessment_id,$Project_id);
            }
        }
  }
  function display2($Reg_number,$Assessment_id,$Project_id)
  {

    require '../dbh/dbh.php';
  

              $sql = "SELECT Name, Surname FROM Students WHERE Reg_number = '$Reg_number'";
              $result = mysqli_query($Conn,$sql);
              $confirm = mysqli_num_rows($result);
              if ($confirm > 0)
              { 
                echo "<tr>";
          
              while ($row = mysqli_fetch_assoc($result))
                {
                    $Name = $row['Name'];
                    $Surname = $row['Surname'];

                    echo "<td>".$Name."</td>".
                         "<td>".$Surname."</td>".
                         "<td>".$Reg_number."</td>";
                         display4($Project_id);
                         display3($Assessment_id);
                         display5($Project_id,$Assessment_id);
                }
              }
}
function display3($Assessment_id)
{
  require '../dbh/dbh.php';


                    $sql = "SELECT Assessment_title FROM assessment_details WHERE Assessment_id = '$Assessment_id'";
                    $result = mysqli_query($Conn,$sql);
                    $confirm = mysqli_num_rows($result);
                    if ($confirm > 0)
                      {
                        while ($row = mysqli_fetch_assoc($result))
                          {
                              $a_title = $row['Assessment_title'];
                                echo "<td>".$a_title."</td>";
                          }
                        }
}
function display4($Project_id)
{
  require '../dbh/dbh.php';


                              $sql = "SELECT Project_title,Supervisor,Level FROM Projects WHERE Project_id = '$Project_id'";
                              $result = mysqli_query($Conn,$sql);
                              $confirm = mysqli_num_rows($result);
                              if ($confirm > 0)
                              {
                                 while ($row = mysqli_fetch_assoc($result))
                                   {
                                     $p_title = $row['Project_title'];
                                     $Supervisor = $row['Supervisor'];

                                      echo "<td>".$p_title."</td>".
                                            "<td>".$row['Level']."</td>".
                                            "<td>".$Supervisor."</td>";
                                    }
                              }
}
function display5($Project_id,$Assessment_id)
{
  require '../dbh/dbh.php';


                                    $sql = "SELECT Overal_mark FROM final_mark WHERE Project_id ='$Project_id' AND Assessment_id ='$Assessment_id'";
                                      $result = mysqli_query($Conn,$sql);
                                    $confirm = mysqli_num_rows($result);

                                    if ($confirm > 0)
                                      {
                                        while ($row = mysqli_fetch_assoc($result))
                                         {
                                          $mark = $row['Overal_mark'];
                                          echo "<td>".$mark."</td>";
                                         }
                                       }
}
function marks_table($value='')
{
  
  echo "<div class='col-md-12'>".
                    "<div class='tile'>".
                      "<div class='tile-body'>".
                        "<table class='table table-hover table-bordered' id='sampleTable'>".
                          "<thead>".
                                "<tr>".
                                  "<th>"."Name"."</th>".
                                  "<th>"."Surname"."</th>".
                                  "<th>"."Reg-number"."</th>".
                                  "<th>"."Project Title"."</th>".
                                  "<th>"."Level"."</th>".
                                  "<th>"."Supervisor"."</th>".
                                  "<th>"."Assessment"."</th>".
                                  "<th>"."mark"."</th>".
                                "</tr>".
                          "</thead>".
                          "<tbody>";
                          marks();
}
  function student_modal()
  {
         echo "<!-- modal -->".
                 "<div class='modal fade' id='mod9' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>".
                  "<div class='modal-dialog'>".
                    "<div class='modal-content'  style='width: 700px;'>".
                      "<div class='modal-header'>".
                        "<h4>"."New Project"."</h4>".
                        "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>"."&times"."</button>".
                        
                      "</div>".
                      "<div class='modal-body'>".

                      "<form  method='POST' action='../php/propose_project.php' enctype='multipart/form-data'>".

                    "<label class='control-label'>"."Project Title"."</label>".
                    "<input type='text' class='form-control' name='title' required=''>".

                    "<label class='control-label'>"."Project Description"."</label>".
                    "<textarea class='form-control'  name='description' required=''>"."</textarea>".
                     "<label class='control-label'>"."Field of study"."</label>".
                            "<select class='form-control' name='field'>".
                                "<option value='Artificial Intelligence'>"."Artificial Intelligence"."</option>".
                                "<option value='Big Data'>"."Big Data analytics"."</option>".
                                "<option value='Internet of Things'>"."IOT"."</option>".
                                "<option value='Expect Systems'>"."Expect Systems"."</option>".
                            "</select>".
                            "<br>".
                            "<input type='text' name='other' placeholder='specify if other' class='form-control' required=''>".
                            "<br>".

                            "<label class='control-label'>"."Attachments"."</label>".
                            "<input type='file' name='file'>".                            
                                                      "<label class='control-label'>"."What file are you attachment"."</label>".
                                                      "<textarea class='form-control' name='attachment'>"."</textarea>".
                                                      "<br>".
                            
                                                     "<label class='control-label'>"."Proposed Tools (languages to be used)"."</label>".
                                                      "<textarea class='form-control' name='tools' required=''>"."</textarea>".
                                                      "<br>".
                                                  "<div class='row'>".
                                                   "<div class='col-md-6'>".
                                                        "<label class='control-label'>"."Year"."</label>".
                                                         "<select class='form-control' name='year'>".
                                                          "<option value='2018/2019'>"."2018/2019"."</option>".
                                                          "<option value='2017/2018'>"."2017/2019"."</option>".
                                                        "</select>".
                                                    "</div>".
                                                      "<div class='col-md-6'>".
                                                        "<label class='control-label'>"."course code"."</label>".
                                                         "<select class='form-control' name='course'>".
                                                          "<option value='hit200'>"."Hit200"."</option>".
                                                          "<option value='hit400'>"."Hit400"."</option>".
                                                        "</select>".
                                                    "</div>".
                                                  "</div>".
                                                "<br>"."<br>".             
                                                  "</div>".
                                                  "<div class='modal-footer>".
                                                    "<button data-dismiss='modal' class='btn btn-default' type='button'>"."Close"."</button>".
                        "<button class='btn btn-success' type='submit' name='submit'>"."Save changes"."</button>".
                      "</div>".
                      "</form>".
                    "</div>".
                  "</div>".
                "</div>".
                "<!-- modal -->";
  }                              

