<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href = "css/KingLib_6.css">
</head>
<body>

<div id="logo">
<img src="http://profperry.com/Classes20/PHPwithMySQL/KingLibLogo.jpg" > 
</div>

<div id="patron">

<?php
	include "assignment_6_db_functions.php"; //pulls in PHP functions from another file

//*********************************************
//Gather data from form
//*********************************************

if (isset ($_POST['submitButton']))
{
	$mySubmitButton = trim($_POST['submitButton']);
}

else
{
	$mySubmitButton == '';
}

$current_year=date('Y');
if($mySubmitButton == 'Submit Information')
{
	if(isset($_POST['patron_id']))
	{
		$patron_id = trim($_POST['patron_id']);
	}
	else
	{
		$patron_id = '';
	}

	if(isset($_POST['lastname']))
	{
		$lastname = trim($_POST['lastname']);
	}
	else
	{
		$lastname = '';
	}

	if(isset($_POST['firstname']))
	{
		$firstname = trim($_POST['firstname']);
	}
	else
	{
		$firstname = '';
	}

	if(isset($_POST['email']))
	{
		$email = trim($_POST['email']);
	}
	else
	{
		$email = '';
	}

	if(isset($_POST['city']))
	{
		$city = trim($_POST['city']);
	}
	else
	{
		$city = '';
	}
	
	if(isset($_POST['birthYear']))
	{
		$birthYear = trim($_POST['birthYear']);
		$age = $current_year - $birthYear;
	}
	else
	{
		$birthYear = '';
	}
}

//determine age group

if($age >= 0 && $age <= 15)
{
	$section = 'Children';
}
if($age >= 16 && $age <=54)
{
	$section = 'Adult';
}
if($age >= 55)
{
	$section = 'Senior';
}

//determine if any errors in form submission
$errorFoundFlag = 'N'; //initialize error flag

if(empty($firstname))
{
	print "Error: You must enter a First Name <br/>";
	$errorFoundFlag = 'Y';
}

if(empty($lastname))
{
	print "Error: You must enter a Last Name <br/>";
	$errorFoundFlag = 'Y';
}

if(empty($email))
{
	print "Error: You must enter your Email <br/>";
	$errorFoundFlag = 'Y';
}

if(empty($birthYear))
{
	print "Error: You must enter your Birth Year <br/>";
	$errorFoundFlag = 'Y';
}

if(!is_numeric($birthYear))
{
	print "Error: The Birth Year you enter must be numeric <br/>";
	$errorFoundFlag = 'Y';
}

if(empty($city))
{
	print "Error: You must select a City <br/>";
	$errorFoundFlag = 'Y';
}

if($errorFoundFlag == 'Y')
{
	print "<br/>Go BACK and make corrections<br/>";
}


//*******************************************
// Display information from form
//*******************************************
else
{

	$rtninfo = insertPatron($db, $lastname, $firstname, $email, $city, $birthYear);

	if($rtninfo == "NotAdded")
	{
		print "<p style='color: red'>Patron Not Added</p>";
	}
	else
	{

		print "Thank You for Registering!<br/>";

		print "<p>Name: 
			$firstname ";
		print "$lastname</p>";
		print "<p>Email:
			$email</p>";
		print "<p>City: 
			$city</p>";
		print "<p>Section:
			$section</p>";
	}

}//end else
?>

<p>
For Admin Use Only: 
<a href = "assignment_6_view_patron.php" >View Patrons</a> 
<p/>

</div>
</body>
</html>

//**************************************
//Insert a new row into the patron table 
//**************************************

<?php
function insertPatron($db, $lastname, $firstname, $email, $city, $birthYear)
{
	$db = connectDatabase();

	$statement = "insert into Patron (lastname, firstname, email, city, birthYear) ";
	$statement .= "values (";
	$statement .= "'".$lastname."', '".$firstname."', '".$email."', '".$city."', '".$birthYear."'";
	$statement .= ")";

	$result = mysqli_query($db, $statement);

	if($result)
	{
		return $patron_id;
	} 
	else
	{
		$errno = mysqli_errno($db);

		if($errno == '1062')
		{
			echo "<p style='color: red'>Patron with Patron ID of ".$patron_id. " is already in Table ";
		}
		else
		{
			echo("<h4>MySQL No: ".mysqli_errno($db)."</h4>");
			echo("<h4>MySQL Error: ".mysqli_error($db)."</h4>");
			echo("<h4>SQL: ".$statement."</h4>");
			echo("<h4>MySQL Affected Rows: ".mysqli_affected_rows($db)."</h4>");
		}

		return 'NotAdded';
	}
	
}
?>


