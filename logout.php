<?php

    function rec_logout($username,$email)
    {
    	$login_file = "loginFile.txt";
        $log = fopen($login_file,"a") or die ("Cannot open file");
        $date = (new DateTime())->setTimeZone(new DateTimeZone('Asia/Kolkata'))->format('d/m/y - H:i:s a');
        $str =  " ".$date. " - " .$username. " - " . $email . " - " ." logged out\n";
        fwrite ( $log, $str);
        fclose($log);
    }
    session_start();
    $username = $_SESSION['name'];
    $email = $_SESSION['user'];
    if ( (strcmp ($email,"admin@gmail.com") !=0))
        rec_logout($username,$email);
    session_destroy();
    header("location:index.php");
?>