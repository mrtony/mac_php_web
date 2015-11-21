<?php
include "NotORM.php";
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '123456';
    $dbname = 'HR';
	$dsn = "mysql:dbname=HR;host=localhost";
	$pdo = new PDO($dsn, $dbuser, $dbpass);
	$library = new NotORM($pdo);
	
	// $employees = $library->employees();
	// foreach ($employees as $employee) {
	// 	echo $employee["FirstName"] . " " . $employee["LastName"] . "<br>";
	// }
	
	$filterEmployees = $library->employees->where("Salary > ?",  6500);
	foreach ($filterEmployees as $employee) {
		echo $employee["FirstName"] . " " . $employee["LastName"] . $employee["Salary"] . "<br>";
	}
?>