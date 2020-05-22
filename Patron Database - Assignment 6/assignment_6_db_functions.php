<?php
function connectDatabase()
{
	require('../../DBtest_pptest.php');

		$host =  'localhost';
		$userid =  'P23';   
		$password = '7dosql7';
		$dbname = 'testdb';

		$db = mysqli_perry_pconnect($host, $userid, $password, $dbname);

		if (!$db)
		{
			print "<h1>Unable to Connect to MySQLi</h1>";
			exit;
		}

		return $db;
} //end connectDatabase function

?>