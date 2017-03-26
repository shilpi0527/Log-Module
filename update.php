<?php 
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="StudentDB"; // Database name 
$tbl_name="some"; // Table name 

// Connect to server and select database. 
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB"); 

$sql="SELECT * FROM $tbl_name"; 
$result=mysql_query($sql); 
?> 
<table width="400" border="0" cellspacing="1" cellpadding="0"> 
<tr> 
<td> 
<table width="400" border="1" cellspacing="0" cellpadding="3"> 
<tr> 
<td colspan="4"><strong>List data from mysql </strong> </td> 
</tr> 

<tr> 
<td align="center"><strong>Name</strong></td> 
<td align="center"><strong>Address</strong></td> 
<td align="center"><strong>Email_Id</strong></td> 
<td align="center"><strong>mob_num</strong></td> 
<td align="center"><strong>Update</strong></td> 
</tr> 
<?php 
while($rows=mysql_fetch_array($result)){ 
?> 
<tr> 
<td><? echo $rows['Nameame']; ?></td> 
<td><? echo $rows['Address']; ?></td> 
<td><? echo $rows['Email_Id']; ?></td> 
<td><? echo $rows['mob_num']; ?></td> 
// link to update.php and send value of id 
<td align="center"><a href="update.php?id=<? echo $rows['name']; ?>">update</a></td> 
</tr> 
<?php 
} 
?> 
</table> 
</td> 
</tr> 
</table> 
<?php 
mysql_close(); 
?> 

<?php 
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="159753@Sp#"; // Mysql password 
$db_name="shilpi"; // Database name 
$tbl_name="Address_book"; // Table name 

// Connect to server and select database. 
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB"); 

// update data in mysql database 
$sql="UPDATE $tbl_name SET  Address='$Address', Email_Id='$Email_Id,mob_num='mob_num' WHERE Name='$Name'"; 
$result=mysql_query($sql); 

// if successfully updated. 
if($result){ 
echo "Successfully Updated the database"; 
echo "<BR>"; 
echo "<a href='list_records.php'>View result</a>"; 
} 

else { 
echo "ERROR"; 
} 

?> 