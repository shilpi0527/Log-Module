
<html>
    <head>
       <title>Admin Page</title>

    <script>
       function clearForm(oForm) 
       {
          var elements = oForm.elements; 
          oForm.reset();
          for(i=0; i<elements.length; i++) 
          {
             field_type = elements[i].type.toLowerCase();
             switch(field_type) 
             {
                case "text": elements[i].value = ""; break;
                case "checkbox": if (elements[i].checked) { elements[i].checked = false; } break;
                default:  break;
             }
         }
      }

      function printPage()
      {
        window.print();
      }


  </script>
  </head>
    <style>
        body
        {
            margin:0px;
            background-color:#848484;
        }
        #header 
        {
            background-color:white;
            padding: 1px;
        }
        p{
          padding-left: 30px;
        }
        #main
        {
          margin-left: 500px;
          width :550px;
          font-size: 20px;
        }
        .log_table
        {
           margin-left: 120px;
           margin-bottom: 50px;
           width: 1200px;
        }
        .input
        {
          width: 200px;
          font-size: 15px;
        }
        #btnDone
        {
          width: 100px;
          height: 30px;
          font-size: 18px;
          margin-left: 600px;
        }
        #btnClear
        {
          width:100px;
          height:30px;
          font-size: 18px;
          margin-left: 50px;
        }
        #btnDl
        {
          margin-left: 20px;
          width: 100px;
          height: 30px;
          font-size: 18px;
        }
        #btnPrint
        {
          margin-left: 235px;
          width: 100px;
          height: 30px;
          font-size: 18px;
        }
        a
        {
          margin-left: 30px;
        }
        @media print {
          .printable
        {
      display: none;
        }
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
       <div id="header">
        <p><b>Indira Gandhi Delhi Technical University for Women, Kashmere Gate</b><br>
        Examination Portal Log Details</p>
      </div>
        <p class="printable">Hello <?php Print "$user"?>!</p>  <!--Display's user name-->
        <a class="printable" href="logout.php">Click here to go logout</a><br/>
        <form action = "admintest.php" method="POST" name="myForm">
          <table border = "0px" id="main">
            <tr>
              <td><b>View</b></td>
              <td><b>Of</b></td>
            </tr>
            <tr>
              <td><input style="zoom:1.5" type="checkbox" name="register[]" <?php  if(!empty($_POST['register']))  echo 'checked : "checked"'; ?>> Registration Log</td>
              <td><input id="em" class="input" type="text" name="email" placeholder="Email ID" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"></td>
            </tr>
            <tr>
              <td><input style="zoom:1.5" type="checkbox" name="login[]"<?php  if(!empty($_POST['login']))  echo 'checked : "checked"'; ?>> Login Log</td>
              <td><input id="da" class="input" type="text" name="date" placeholder="Date ( dd/mm/yy ) " value="<?php echo isset($_POST['date']) ? $_POST['date'] : '' ?>"></td>
            </tr>
            <tr>
              <td><input style="zoom:1.5" type="checkbox" name="update[]"  <?php  if(!empty($_POST['update']))  echo 'checked : "checked"'; ?>> Updated Data Log</td>
            </tr>
            </br>
          </table>
        </br>
          <input id="btnDone" class="printable" type="submit" name="submit" value="Done"> 
          <input id="btnClear" class="printable" type="submit" name="clear" value="Clear" onclick="clearForm(this.form);">
          <input id="btnPrint" class="printable" type="submit" name="print" onClick ="printPage();" value="Print File">
          <input id="btnDl" class="printable" type="submit" name="dl" onClick="window.open('download.php')" value="Download File">
          
       


  </body>
</html>
<?php

    read_log_file();

    function read_log_file()   // Function to check for the checked boxes values
    {
      
          require_once 'Spreadsheet/Excel/Writer.php';
          // Creating a workbook
$workbook = new Spreadsheet_Excel_Writer('some.xls');

// sending HTTP headers


// Creating a worksheet
$worksheet =& $workbook->addWorksheet('My first worksheet');


// Let's send the file



        if ( isset($_POST['clear']));

        if(isset($_POST['submit']))
        {
          $i=0;
          
           global $i;
          


         // $GLOBALS['i'] = 0;
        //  $file_open = false; 
          $check_count = false;
          if (!empty($_POST['register']))
          {
             $log = fopen("registerFile.txt",'r');
             $check_count = true;
           //  $file_open = true;
             $worksheet->write($i,0,'Register Details :');

             $i++;
          //   $dl_file = fopen ("igdtuw-logfile.xls",'w');
             
           //  fwrite ( $dl_file, "Register Log : \n");
             check_for_text($log,$worksheet,1);  // 1 for Login File
          }

          if(!empty($_POST['login']))
          {
             $log = fopen("loginFile.txt",'r');
             $check_count = true;
          //   if ( $file_open == false )
           //  {
               // $dl_file = fopen ("igdtuw-logfile.xls",'w');
            //    $file_open = true;
            // }
             $worksheet->write($i,0,'Login Details :');
             $i++;
           //  fwrite ( $dl_file, "Login Log : \n");
             check_for_text($log,$worksheet,2);
          }


          if (!empty($_POST['update']))
          {
             $log = fopen("updateFile.txt",'r');
             $check_count = true;
           /*  if ( $file_open == false )
             {
                $dl_file = fopen ("igdtuw-logfile.xls", 'w');
             }
             
             fwrite ( $dl_file, "Updated Data Log : \n");*/
             $worksheet->write($i,0,'Update Details :');
             $i++;
             check_for_text($log,$worksheet,3);            
          }
          
          if ( $check_count )
          {
            
            $workbook->close();
             // fclose($dl_file);
            }


          if (!$check_count)
          {
             Print '<script>alert("Please Choose One");</script>';
             Print '<script>Window.location.assign("admin.php");</script>';
          }
        }
    }

    function check_for_text($log,$worksheet,$file)   // Function to check for entered Email ID and Date
    {
       $table ='';
       if ( !empty($_POST['email']))// && !empty($_POST['date']))
       {
          $email = $_POST['email'];
          if ( !empty($_POST['date']))
          {
             $date=$_POST['date'];
             $line = fgets($log);
             $found =false;
             $match = 0;

             while(!feof($log))
             {
                if(strpos($line,$email) != false ) //&& strpos($line,$email) !== false)
                {
                    if ( strpos($line,$date)!= false)
                    {
                       $match++;
                       $found = true;
                       display ($match, $line, $file, $table, $worksheet);
                    //   fwrite ( $dl_file, $line);
                    }
                }
                $line = fgets($log);
             }
            
             if(!$found)
             {
                 if ( $file == 1)
                    $table = '<table border="1" class="log_table" ><tr><td colspan="4">Registration Details</td></tr><tr><td>No record found</td></tr>';
                 else if ( $file == 2 )
                    $table = '<table border="1" class="log_table" ><tr><td colspan="4">Login / Logout Details</td></tr><tr><td>No record found</td></tr>';
                 else
                    $table = '<table border="1" class="log_table" ><tr><td colspan="6">Updated Records Details</td></tr><tr><td>No record found</td></tr>';

                 echo $table;
                 $worksheet->write($i,0,'No record found');

              //   fwrite ( $dl_file, "No record found. \n");
             }
          }
          else
          {
              $email = $_POST['email'];
              search($log,$email,$worksheet,$file,$table);
          }
       }
       else if (!empty($_POST['date']))
       {
          $date=$_POST['date'];
          search($log,$date,$worksheet,$file,$table);
       }
       else
       { 
          $match =0;
          $line = fgets($log);
          while ( !feof($log))
          {
             $match++;
             display ($match, $line, $file ,$table,$worksheet);
          //   fwrite ( $dl_file, $line);
             $line = fgets($log);
          }
       }
       fclose($log);
    }

    function display ( $match, $line, $file, $table,$worksheet)
    {
      global $i;
        if ( $match == 1 )
        {

           if ( $file == 1 )
           {
              
              $table = '<table border="1" class="log_table" ><tr><td colspan="4">Registration Details</td></tr><tr><th>Date</th><th>Time</th><th>Name</th><th>Email ID</th></tr>';
              $worksheet->write($i,0,'Date');
              $worksheet->write($i,1,'Time');
              $worksheet->write($i,2,'Name');
              $worksheet->write($i,3,'Email ID');
              $i++;

           }
           else if ( $file == 2 )
           {
              $table = '<table border="1" class="log_table" ><tr><td colspan="5">Login / Logout Details</td></tr><tr><th>Date</th><th>Time</th><th>Name</th><th>Email ID</th><th>Action</th></tr>';
              $worksheet->write($i,0,'Date');
              $worksheet->write($i,1,'Time');
              $worksheet->write($i,2,'Name');
              $worksheet->write($i,3,'Email ID');
              $worksheet->write($i,4,'Action');
              $i++;
           }
           else
           { 
              $table = '<table border="1" class="log_table" ><tr><td colspan="7">Updated Records Details</td></tr><tr><th>Date</th><th>Time</th><th>Name</th><th>Email ID</th><th>Updated</th><th>From</th><th>To</th></tr>';
              $worksheet->write($i,0,'Date');
              $worksheet->write($i,1,'Time');
              $worksheet->write($i,2,'Name');
              $worksheet->write($i,3,'Email ID');
              $worksheet->write($i,4,'Updated');
              $worksheet->write($i,5,'From');
              $worksheet->write($i,6,'To');
              $i++;
           }
        }
        if ( $file == 1 )
        {
            list ( $datestamp, $timestamp, $username, $emailid) = explode('-', $line);
            $table .="<tbody><tr><td>$datestamp</td><td>$timestamp</td><td>$username</td><td>$emailid</td></tr></tbody>";   
            $worksheet->write($i,0,$datestamp);
            $worksheet->write($i,1,$timestamp);
            $worksheet->write($i,2,$username);
            $worksheet->write($i,3,$emailid);
            $i++; 
        }
        else if ( $file == 2 )
        {
            list ( $datestamp, $timestamp, $username, $emailid, $action) = explode('-', $line);
            $table .="<tbody><tr><td>$datestamp</td><td>$timestamp</td><td>$username</td><td>$emailid</td><td>$action</td></tr></tbody>";
            $worksheet->write($i,0,$datestamp);
            $worksheet->write($i,1,$timestamp);
            $worksheet->write($i,2,$username);
            $worksheet->write($i,3,$emailid);
            $worksheet->write($i,4,$action);
            $i++; 
        }
        else
        {
            list ( $datestamp, $timestamp, $username, $emailid, $updated,$from,$to) = explode('-', $line);
            $table .="<tbody><tr><td>$datestamp</td><td>$timestamp</td><td>$username</td><td>$emailid</td><td>$updated</td><td>$from</td><td>$to</td></tr></tbody>";
            $worksheet->write($i,0,$datestamp);
            $worksheet->write($i,1,$timestamp);
            $worksheet->write($i,2,$username);
            $worksheet->write($i,3,$emailid);
            $worksheet->write($i,4,$updated);
            $worksheet->write($i,5,$from);
            $worksheet->write($i,6,$to);
            $i++; 
        }
        
        echo $table;
        $table .='</table>';

    }

    function search( $log,$check,$worksheet,$file,$table)  // Function to find the data in the Log File
    {
       $line = fgets($log);
       $found =false;
       $match = 0;
       while(!feof($log))
       {
          if(strpos($line,$check) != false )
          {
              $found = true;
              $match++;
              display ($match, $line, $file,$table,$worksheet);
             // fwrite ( $dl_file, $line);
          }
          $line = fgets($log);
       }

       if(!$found)
       {
          if ( $file == 1)
              $table = '<table border="1" class="log_table" ><tr><td colspan="4">Registration Details</td></tr><tr><td>No record found</td></tr>';
          else if ( $file == 2 )
              $table = '<table border="1" class="log_table" ><tr><td colspan="4">Login / Logout Details</td></tr><tr><td>No record found</td></tr>';
          else
              $table = '<table border="1" class="log_table" ><tr><td colspan="6">Updated Records Details</td></tr><tr><td>No record found</td></tr>';

          echo $table;
          $worksheet->write($i,0,'No record found');

     //     fwrite ( $dl_file, "No record found \n");
       }
    }
?>
