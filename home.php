
<html>
    <head>
       <title>Home Page</title>
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
   ?>
    <body>
        <h2>Home Page</h2>
        <p>Hello <?php Print "$user"?>!</p>  <!--Display's user name-->
        <a href="logout.php">Click here to go logout</a><br/><br/>
    <table border="1px" width="100%">
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
          mysql_connect("localhost","root","") or die(mysql_error());
          mysql_select_db("StudentDB") or die("Cannot connect to database");
          $query=mysql_query("Select * from StudentDetails where email='$user'");
          while($row=mysql_fetch_array($query))
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
            Print "<tr>";
               Print '<td align="center"> </td>';
               Print '<td align="center"> </td>';
               Print '<td align="center"> </td>';
               Print '<td align="center"><a href="editpassword.php?id='. $row['id'] .'">Edit Password</a></td>'; 
               Print '<td align="center"><a href="editcourse.php?id='. $row['id'] .'">Edit Course Name</a></td>';
               Print '<td align="center"><a href="edityear.php?id='. $row['id'] .'">Edit Year</a></td>'; 
               Print '<td align="center"><a href="editmobile.php?id='. $row['id'] .'">Edit Mobile Number</a></td>'; 

            Print "</tr>";
            //Print '<a href="edit.php?id='. $row['id'] .'">Click here to Edit Profile</a>';
          }
          ?>
    </table>
  </body>
</html>
