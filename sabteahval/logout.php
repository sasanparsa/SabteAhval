<?php

session_start();
require "controllers/Utilities.php";

if(array_key_exists( "userid",$_SESSION) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","login.html");

session_unset();
session_destroy();

Redirect("login.html");

?>