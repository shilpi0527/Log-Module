<?php
    $file = 'igdtuw-logfile.xls';

    if(!file_exists($file)) die("I'm sorry, the file doesn't seem to exist.");

    $type = filetype($file);

    // Send file headers
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment;filename=igdtuw.xls");
    header("Content-Transfer-Encoding: binary"); 
    header('Pragma: no-cache'); 
    header('Expires: 0');
    // Send the file contents.
    set_time_limit(0); 
    readfile($file);


    
?>