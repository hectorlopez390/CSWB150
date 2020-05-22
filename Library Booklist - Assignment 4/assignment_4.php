<!DOCTYPE html>
<html>
<head>
</head>
<body style="background-color: lightblue;">

<div id="logo">
<img src="http://profperry.com/Classes20/PHPwithMySQL/KingLibLogo.jpg" > 
</div>

<h3 style="color:Blue;"> Enter KeyWord to Search for Titles: </h3> 

<form method = "post" action = "assignment_4_booklist.php">

<input type = "text" name = "keyword" size = "30"/>

	Sort Order: 
	<input type = "radio" id = "ascending" name = "order" value = "ascending" checked>
	<label for = "ascending">Ascending</label>
	<input type = "radio" id = "descending" name = "order" value = "descending">
	<label for = "descending">Descending</label>

<br/> (leave blank to list all titles)

<p><input type = "submit" value = "Find Titles"></p>

</form>

</body>
</html>