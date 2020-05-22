<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href = "css/KingLib_3.css">
</head>
<body>

<div id ="logo">
<img src="http://profperry.com/Classes20/PHPwithMySQL/KingLibLogo.jpg" >
</div>

<div id = "patronlist">

<p>
<h1>View Patrons</h1>
</p>

<?php

include "assignment_6_db_functions.php"; //pulls in PHP functions from another file
$db = connectDatabase(); //connects database

//*****************************************************
//Read Name Information from db into an HTML table
//*****************************************************

$sql_statement = "SELECT lastname, firstname, email, city, birthYear ";
$sql_statement .= "FROM Patron ";
$sql_statement .= "ORDER BY lastname, firstname ";
$result = mysqli_query($db, $sql_statement);  //Run SELECT

//detect if no patrons have yet been added
$numresults = mysqli_num_rows($result);
if ($numresults == 0)
{
	exit('No Patrons found');
}

$display = "";
$line_ctr = 0;

if(!$result)
{
	$display .= "<p style='color: red;'>MySQL No: ".mysqli_errno($db)."<br>";
	$display .= "MySQL Error: ".mysqli_error($db)."<br>";
	$display .= "<br>SQL: ".$sql_statement."<br>";
	$display .= "<br>MySQL Affected Rows: ".mysqli_affected_rows($db)."</font><br>";
}
else
{
	$display .= "<table border = '1' >

	<tr>
	<th>Last Name</th>
	<th>First Name</th>
	<th>Email</th>
	<th>City</th>
	<th>Birth Year</th>
	</tr>";
	
	for($i = 0; $i < $numresults; $i++)
	{
		if(!($i % 2) == 0)
		{
			$display .= "<tr style =\"background-color: #FFFFCC;\">";
		}
		else
		{
			$display .= "<tr style =\"background-color: white;\">";
		}

		$line_ctr++;
		
		$row = mysqli_fetch_array($result);

		
		$lastname = $row['lastname'];
		$firstname = $row['firstname'];
		$email = $row['email'];
		$city = $row['city'];
		$birthYear = $row['birthYear'];

		$display .= "<td>".$lastname."</td>";
		$display .= "<td>".$firstname."</td>";
		$display .= "<td>".$email."</td>";
		$display .= "<td>".$city."</td>";
		$display .= "<td>".$birthYear."</td>";
		$display .= "</tr>";
	}
	$display .= "</table>";
}

print $display;

?>

</div>
</body>