<html>
    <head>
        <title>Edit Profile</title>
    </head>
    <style>
        body
        {
            margin:0px;
            background-color:#848484;
        }
        h2 
        {
            background-color:white;
            padding:30px;
        }
        p{
          padding-left: 30px;
        }
    </style>
   <?php
   session_start(); //starts the session
   if($_SESSION['user']){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   $user = $_SESSION['user']; //assigns user value
   $id_exists = false; 
   ?>
    <body>
        <h2>Edit Mobile Number</h2>
        <p>Hello <?php Print "$user"?>!</p> <!--Display's user name-->
        <a href="logout.php">Click here to go logout</a><br/><br/>
        <a href="home.php">Return to home page</a>
        <h3 align="center">Current Details</h3>
        <table border = "1px" width = "100%">
           <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email ID</th>
              <th>Password</th>
              <th>Course</th>
              <th>Year</th>
              <th>Mobile Number</th> 
           </tr>
          <?php
              if (!empty($_GET['id']))
              {
                 $id=$_GET['id'];
                 $_SESSION['id'] = $id;
                 $id_exists = true;
                 mysql_connect("localhost","root","") or die (mysql_error());
                 mysql_select_db("StudentDB") or die("Cannot connect to database");
                 $query = mysql_query("Select * from StudentDetails where id='$id'");
                 $count = mysql_num_rows($query);
                 if($count > 0 )
                 {
                  while ( $row=mysql_fetch_array($query))
                  {
                     Print "<tr>";
                        Print '<td align="center">'. $row['id'] . "</td>";
                        Print '<td align="center">'. $row['username']. "</td>";
                        Print '<td align="center">'. $row['email']. "</td>";
                        Print '<td align="center">'. $row['password']. "</td>";
                        Print '<td align="center">'. $row['course']. "</td>";
                        Print '<td align="center">'. $row['year']. "</td>";
                        Print '<td align="center">'. $row['mobile']. "</td>";
                     Print "</tr>";
                  }
                 }
                 else
                 {
                  $id_exists=false;
                 }
              }
              ?>
            </table>
            <br/>
            <?php
            if($id_exists)
            {
              Print ' <br>
              <form action = "editmobile.php" method="POST">
                 Change Mobile Number: <input type="number" name="mobile" placeholder="New Mobile Number"/><br/><br/>
                 <input type="submit" value="Update Profile"/>
              </form>
              ';
            }
            else
            {
              Print '<h2 align="center">There is nothing to be edited.</h2>';
            }
            ?>
      </body>
    </html>

  <?php

  function rec_update( $id, $mobile )
  {
       $query = mysql_query("SELECT * from StudentDetails WHERE id='$id'"); //Query the users table if there are matching rows equal to $email
       $row = mysql_fetch_assoc($query); //display all rows from query
       $username= $row['username'];
       $email = $row['email'];
       $m = $row['mobile'];
       $update_file = "updateFile.txt";
       $log = fopen($update_file,"a") or die ("Cannot open file");
       $date = (new DateTime())->setTimeZone(new DateTimeZone('Asia/Kolkata'))->format('d/m/y - H:i:s a');
       $str = " ".$date. " - " . $username . " - " . $email . " - Mobile Number - " . $m . "  -  " . $mobile . "\n";
       fwrite ( $log, $str);
       fclose($log);
  }

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    mysql_connect("localhost", "root","") or die(mysql_error()); //Connect to server
    mysql_select_db("StudentDB") or die("Cannot connect to database"); //Connect to database

    $id = $_SESSION['id'];
    $mobile = mysql_real_escape_string($_POST["mobile"]);

    rec_update ( $id, $mobile );   // Function call to record update activity 

    mysql_query("UPDATE StudentDetails SET mobile='$mobile' WHERE id='$id'") ;
    header("location: home.php");
  }
?>
