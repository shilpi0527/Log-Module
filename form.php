<?php
    read_log_file();

    function read_log_file()   // Function to check for the checked boxes values
    {

        if ( isset($_POST['clear']));

        if(isset($_POST['submit']))
        {
// When executed in a browser, this script will prompt for download 
// of 'test.xls' which can then be opened by Excel or OpenOffice.

require 'php-export-data.class.php';

// 'browser' tells the library to stream the data directly to the browser.
// other options are 'file' or 'string'
// 'test.xls' is the filename that the browser will use when attempting to 
// save the download
$exporter = new ExportDataExcel('browser', 'test.xls');

$exporter->initialize(); // starts streaming data to web browser

// pass addRow() an array and it converts it to Excel XML format and sends 
// it to the browser
$exporter->addRow(array("This", "is", "a", "test")); 
$exporter->addRow(array(1, 2, 3, "123-456-7890"));

// doesn't care how many columns you give it
$exporter->addRow(array("foo")); 
$exporter->finalize(); // writes the footer, flushes remaining data to browser.


          $file_open = false; 
          $check_count = false;
          if (!empty($_POST['register']))
          {
             $log = fopen("registerFile.txt",'r');
             $check_count = true;
             $file_open = true;
             $exporter->initialize(); // starts streaming data to web browser
             $exporter->addRow(array("Registration Details :")); 
             $exporter->finalize(); // writes the footer, flushes remaining data to browser.
             check_for_text($log,1,$exporter);  // 1 for Login File
          }


          if(!empty($_POST['login']))
          {
             $log = fopen("loginFile.txt",'r');
             $check_count = true;
             if ( $file_open == false )
             {
                $file_open = true;
             }
             $exporter->initialize(); // writes the footer, flushes remaining data to browser.
             $exporter->addRow(array("Login Details :")); 
             $exporter->finalize(); // writes the footer, flushes remaining data to browser.
             check_for_text($log,2,$exporter);
          }


          if (!empty($_POST['update']))
          {
             $log = fopen("updateFile.txt",'r');
             $check_count = true;
             if ( $file_open == false )
             {
                
             }
             $exporter->initialize(); // writes the footer, flushes remaining data to browser.
             $exporter->addRow(array("Update Details :")); 
             $exporter->finalize(); // writes the footer, flushes remaining data to browser.
             check_for_text($log,3,$exporter);            
           }
          if ( $check_count )
          {



exit(); // all done
              fclose();
            }

          if (!$check_count)
          {
             Print '<script>alert("Please Choose One");</script>';
             Print '<script>Window.location.assign("form.php");</script>';
          }
        }
    }

    function check_for_text($log,$file,$exporter)   // Function to check for entered Email ID and Date
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
                       display ($match, $line, $file, $table,$exporter);
                       
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

                 
             }
          }
          else
          {
              $email = $_POST['email'];
              search($log,$email,$file,$table,$exporter);
          }
       }
       else if (!empty($_POST['date']))
       {
          $date=$_POST['date'];
          search($log,$date,$file,$table,$exporter);
       }
       else
       { 
          $match =0;
          $line = fgets($log);
          while ( !feof($log))
          {
             $match++;
             display ($match, $line, $file ,$table,$exporter);
             
             $line = fgets($log);
          }
       }
       fclose($log);
    }

    function display ( $match, $line, $file, $table,$exporter)
    {
        if ( $match == 1 )
        {
           if ( $file == 1 )
           {

              $table = '<table border="1" class="log_table" ><tr><td colspan="4">Registration Details</td></tr><tr><th>Date</th><th>Time</th><th>Name</th><th>Email ID</th></tr>';
              $exporter->initialize(); // writes the footer, flushes remaining data to browser.
              $exporter->addRow(array("Registration Details"));
              $exporter->addRow(array("Date", "Time", "Name", "Email ID"));
              $exporter->finalize(); // writes the footer, flushes remaining data to browser.

            }
           else if ( $file == 2 )
              $table = '<table border="1" class="log_table" ><tr><td colspan="5">Login / Logout Details</td></tr><tr><th>Date</th><th>Time</th><th>Name</th><th>Email ID</th><th>Action</th></tr>';
           else 
              $table = '<table border="1" class="log_table" ><tr><td colspan="7">Updated Records Details</td></tr><tr><th>Date</th><th>Time</th><th>Name</th><th>Email ID</th><th>Updated</th><th>From</th><th>To</th></tr>';
        }
        if ( $file == 1 )
        {
            list ( $datestamp, $timestamp, $username, $emailid) = explode('-', $line);
            
            $table .="<tbody><tr><td>$datestamp</td><td>$timestamp</td><td>$username</td><td>$emailid</td></tr></tbody>";    
            $exporter->intialize(); // writes the footer, flushes remaining data to browser.
            $exporter->addRow(array($datestamp, $timestamp, $username, $emailid));
            $exporter->finalize(); // writes the footer, flushes remaining data to browser.
        }
        else if ( $file == 2 )
        {
            list ( $datestamp, $timestamp, $username, $emailid, $action) = explode('-', $line);
            $table .="<tbody><tr><td>$datestamp</td><td>$timestamp</td><td>$username</td><td>$emailid</td><td>$action</td></tr></tbody>";
        }
        else
        {
            list ( $datestamp, $timestamp, $username, $emailid, $updated,$from,$to) = explode('-', $line);
            $table .="<tbody><tr><td>$datestamp</td><td>$timestamp</td><td>$username</td><td>$emailid</td><td>$updated</td><td>$from</td><td>$to</td></tr></tbody>";
        }
        
        echo $table;
        $table .='</table>';

    }

    function search( $log,$check,$file,$table,$exporter )  // Function to find the data in the Log File
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
              display ($match, $line, $file,$table,$exporter);
              
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

          
       }
    }
?>