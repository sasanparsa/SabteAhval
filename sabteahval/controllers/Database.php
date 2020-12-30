<?php

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_DBname = "sabteahval";

function GetDBObject()
{
	global $db_servername;
	global $db_username;
	global $db_password;
	global $db_DBname;
	
	header("Content-Type: text/html;charset=UTF-8");
	$conn = new mysqli($db_servername, $db_username, $db_password,$db_DBname);
	if(!$conn)
		 die("Connection failed: " . mysqli_connect_error());
	 
	 $conn->set_charset("utf8");
	
	return $conn;
}

function Select($query)
{
	try
	{
		$conn = GetDBObject();
		
		$translations = $conn->query($query);
		if($translations->num_rows > 0){
		   $result_arr = array();
			while($translation = $translations->fetch_assoc()){
				$result_arr[] = $translation;
			}
		}
		else{
			$result_arr = array();
		}
		$conn->close();
		return $result_arr;
	}
	catch(Exception $e) 
	{
		return null;
	}
}

function SqlCommand($query)
{
	$conn = GetDBObject();
	$res = 0;
	
	if ($conn->query($query) === TRUE)
	{
		$res = 1;
	} 
	$conn->close();
	return $res;
}



?>