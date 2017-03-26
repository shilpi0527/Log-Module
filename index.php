
<html>
    <head>
       <title>Login Page</title>
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
            margin-top:100px;
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
        <h1>Welcome to the portal</h1>
        <form action="checklogin.php" method="POST">
            Email ID : <input type="text" name="email" placeholder="Enter your Email ID" required="required"><br>
            Password : <input type="password" name="password" placeholder="Enter your Password" required="required"><br><br>
            <button type=“button”>Login</button>
       </form>
       <a href = "register.php">Click here to register</a>
    </body>
</html>