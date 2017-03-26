<?php
   
  function rec_login( $username, $email )  // Function definition - Write Login activity into Log File
  {
      $login_file = "loginFile.txt";
      $log = fopen($login_file,"a") or die ("Cannot open file");
      $date = (new DateTime())->setTimeZone(new DateTimeZone('Asia/Kolkata'))->format('d/m/y - H:i:s a');
      $str = " ".$date. " - " .$username. " - " . $email . " - " ."logged in\n";
      fwrite ( $log, $str);
      fclose($log);
  }

  session_start();
  $email = mysql_real_escape_string($_POST['email']);
  $password = mysql_real_escape_string($_POST['password']);
  mysql_connect("localhost", "root","") or die(mysql_error()); //Connect to server
  mysql_select_db("StudentDB") or die("Cannot connect to database"); //Connect to database
  $query = mysql_query("SELECT * from StudentDetails WHERE email='$email'"); //Query the users table if there are matching rows equal to $email
  $exists = mysql_num_rows($query); //Checks if email exists
  $table_users = "";
  $table_password = "";
  if($exists > 0) //IF there are no returning rows or no existing email
  {
    while($row = mysql_fetch_assoc($query)) //display all rows from query
    {
      $table_users = $row['email']; // the first email row is passed on to $table_users, and so on until the query is finished
      $table_password = $row['password']; // the first password row is passed on to $table_users, and so on until the query is finished
      $username= $row['username'];
      $email = $table_users;
    }
    if(($email == $table_users) && ($password == $table_password)) // checks if there are any matching fields
    {
        $e="admin@gmail.com";
        $p="admin";
        if ( (strcmp ($email,$e) ==0) && (strcmp($password,$p) ==0) )
        {
          $_SESSION['user'] = $email;
          header("location: admin2.php");
        }
        else
        {

          $_SESSION['user'] = $email; //set the email in a session. This serves as a global variable
          $_SESSION['name'] = $username;
          rec_login ( $username , $email );  // Function call to record Login Activity to Log file ( Username to be extracted as well )

          header("location: home.php"); // redirects the user to the authenticated home page

        }
    }
    else
    {
      Print '<script>alert("Incorrect Password!");</script>'; //Prompts the user
      Print '<script>window.location.assign("index.php");</script>'; // redirects to login.php
    }
  }
  else
  {
    Print '<script>alert("Incorrect email!");</script>'; //Prompts the user
    Print '<script>window.location.assign("index.php");</script>'; // redirects to login.php
  }
?>