<!DOCTYPE html>
<html>
<head>
</head>
<body style="background-color: lightblue;">

<div id="logo">
<img src="http://profperry.com/Classes20/PHPwithMySQL/KingLibLogo.jpg" > 
</div>

<?php
//************************************************
//Gather Data from Form
//************************************************

$keyword = $_POST['keyword'];
$sortOrder = $_POST['order'];

$filename = 'data/'.'booklist.txt';

//Check if file exists
if(!file_exists($filename))
{
	exit('No File Found');	
} 
else if(filesize($filename)==0)
{
	exit('No File Found');
}

//Function call passes filename, keyword, order, and returns number of rows and html table
list($total_rows, $theTable) = displayTable($filename, $keyword, $sortOrder);

if($total_rows != 'No Books')
{
	//Decide Headings to display based on data from form
	if($keyword != '' && $sortOrder == 'descending') //Keyword with descending order
	{
		print "<h2>Current Titles that match: ".$keyword."</h2>"; 
		print "<h4>(Sorted in Reverse Alphabetical Order)</h4>";
		print $theTable;
	}
	else if($keyword != '' && $sortOrder == 'ascending') //Keyword with ascending order
	{
		print "<h2>Current Titles that match: ".$keyword."</h2>"; 
		print "<h4>(Sorted in Alphabetical Order)</h4>";
		print $theTable;
	}
	else if($keyword == '' && $sortOrder == 'descending') //No keyword with descending order
	{
		print "<h2>Current Titles</h2>";
		print "<h4>(Sorted in Reverse Alphabetical Order)</h4>";
		print $theTable;
	}
	else //No keyword with ascending order
	{
		print "<h2>Current Titles</h2>";
		print "<h4>(Sorted in Alphabetical Order)</h4>";
		print $theTable;
	}
}

else
{
	print "No Books found";
}

//**********************************************************************
//Read Book Information from file into array and then into an HTML table
//**********************************************************************

function displayTable($filename, $keyword, $sortOrder)
{
	
	$bookList = array();
	
	$lines_in_file = count(file($filename));												
	$fp = fopen($filename, 'r'); //opens the file for reading
	

	for($ii = 1; $ii <= $lines_in_file; $ii++)
	{
		$line = fgets($fp); //Reads line from file
		$book = trim($line); 
		array_push($bookList, $book); 
	}	
		
			
	fclose($fp);
			
	sort($bookList); 
			
	
	$myTable = "\n<table border = '1'>";
	
	$myTable .= "<tr>";
	$myTable .= "	<th>Title</th>";
	$myTable .= "	<th>ISBN</th>";
	$myTable .= "	<th>Type</th>";
	$myTable .= "	<th>Publication Date</th>";
	$myTable .= "</tr>\n\n";

	$line_ctr = 0;

	//Reverse bookList Array if sortOrder is Not Ascending Order
	if($sortOrder != 'ascending')
	{
		rsort($bookList);
	}

	if($keyword != '') //If keyword was entered
	{

		$formattedCounter = 0;
		$formattedBookList = array();

		foreach ($bookList as $element)
		{
			$pos = stripos($element, '*');

			if ($pos === false) //not found in list
			{
				print "</br>";
				exit('Error in .txt file');	
			}

			else //search for keyword in string element
			{	
				$formattedElement = substr($element, 0, $pos);
				$pos = stripos($formattedElement, $keyword);
				if ($pos !== false)
				{
					$formattedBookList[$formattedCounter] = $element;
					$formattedCounter++;
				}
			
			} //end else

		
		} //end foreach

		$bookList = $formattedBookList;

	} //end if

	foreach ($bookList as $element)
	{			
		$line_ctr++;
		$line_ctr_remainder = $line_ctr % 2;
		
		if ($line_ctr_remainder == 0)
		{
			$style = "style = 'background-color: #FFFFCC;'";
		}
		else
		{
			$style = "style = 'background-color: white;'";
		}
	
		list($title, $type, $pubDate, $isbn) = explode('*', $element);

		$myTable .= "<tr $style>";
			$myTable .= "<td>".$title."</td>";
			$myTable .= "<td>".$isbn."</td>";
			$myTable .= "<td>".$type."</td>";
			$myTable .= "<td>".$pubDate."</td>";
			$myTable .= "</tr>\n"; //added newline
	}

	$myTable .= "</table>";

	if($line_ctr == 0)
	{	
		$rtn = array("No Books", " dummy");
		
	}
	else
	{
		$rtn = array($line_ctr, $myTable); //return line counter and html table
	}

	return $rtn;
} 	
	
?>
</body>
</html>
