
<html>
    <head>
       <title>Registration Page</title>
    </head>
    <style>
        body
        {
            margin:0px;
            background-color:#848484;
        }
        h1 
        {
            background-color:white;
            padding:30px;
        }
        form
        {
            padding-left:10px;
            padding-top:10px;
            padding-bottom:10px;
            margin-top:80px;
            margin-left:600px;
            margin-right:600px;
            background-color:white;
            font-size:30px;
        }
        input
        {
            width: 210px;
            font-size: 15px;
        }
        a{
            margin-left: 600px;
        }
        button
        {
            width: 80px;
            height: 30px;
        }
    </style>
    <body>
        <h1>Register Here</h1>
        <form action="register.php" method="POST">
            Name : <input type="text" name="username" placeholder="Enter your Name" required="required"><br>
            Email ID : <input type="text" name="email" placeholder="Enter your Email ID" required="required"><br>
            Password : <input type="password" name="password" placeholder="Enter your Password" required="required"><br>
            Course : <input type="text" name="course" placeholder="Enter your Course" required="required"><br>
            Year : <input type="number" name="year" placeholder="Enter your Academic Year" required="required"><br>
            Mobile Number : <input type="number" name="mobile" placeholder="Enter your Mobile Number"><br><br>
            <button type=“button”>Register</button>
       </form>
       <a href = "index.php">Click here to Login</a>
    </body>
</html>
<?php

    function rec_register($username,$email)  // Function to record registration into Log File 
    {
        $register_file = "registerFile.txt";
        $log = fopen($register_file,'a') or die ("Cannot open file");
        $date = (new DateTime())->setTimeZone(new DateTimeZone('Asia/Kolkata'))->format('d/m/y - H:i:s a');
        $str =  " ".$date. " - " .$username. " - " . $email . "\n";
        fwrite ( $log, $str);
        fclose($log);

    }
    if( $_SERVER["REQUEST_METHOD"] == "POST" )
    {
        $username = mysql_real_escape_string($_POST["username"]);
        $email = mysql_real_escape_string($_POST["email"]);
        $password = mysql_real_escape_string($_POST["password"]);
        $course = mysql_real_escape_string($_POST["course"]);
        $year = mysql_real_escape_string($_POST["year"]);
        $mobile = mysql_real_escape_string($_POST["mobile"]);

        $bool=true;

        mysql_connect("localhost","root","") or die (mysql_error());
        mysql_select_db("StudentDB") or die("Cannot connect to Database");
        $query=mysql_query("Select * from StudentDetails");
        while($row=mysql_fetch_array($query))
        {
            $table_users = $row["email"];
            if ( $email == $table_users )
            {
                $bool=false;
                Print '<script>alert("Email already registered");</script>';
                Print '<script>Window.location.assign("register.php");</script>';
            }
        }

        if($bool)
        {
            rec_register( $username , $email );  // Function Call to record registration activity to Log File

            mysql_query(" INSERT INTO StudentDetails( username, email, password, course, year, mobile ) VALUES ( '$username', '$email', '$password', '$course', '$year', '$mobile' ) ");
            Print '<script>alert("Succesfully registered");</script>';
            //header("location: index.php");
           Print '<script>Window.location.assign("register.php");</script>';
        }
    }
?>