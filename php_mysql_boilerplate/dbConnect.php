<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '123456';
    $dbname = 'HR';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
    mysql_select_db($dbname);
	$query="SELECT * FROM employees";
	$result=mysql_query($query) or die('MySQL query error');
    $num = mysql_numrows($result);
    mysql_close();
    while($row = mysql_fetch_array($result)){
        echo $row["FirstName"];
    }

?>