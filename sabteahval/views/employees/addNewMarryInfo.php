<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");


$page = "ثبت اطلاعات ازدواج";
$cnt = "";

$cnt = "<style>form input[type=text]{border-radius:2px;border:1px solid #ababab;} .cnt{height:600px;} td{border:none} .lw{direction:ltr;}</style>";
				
$cnt = $cnt. "<form method='post' action='../../controllers/Controller.php'><div><table>";				
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی مرد : </label></td><td> <input type="text" name="mannat" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی زن : </label></td><td> <input type="text" name="womannat" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تاریخ ازدواج : </label></td> <td><input type="text" name="marrydate" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><td><div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="addNewMarryInfo_btn">ثبت</button></div><td></tr>';
$cnt = $cnt.'</table></div>';
$cnt = $cnt.'</form>';
include "employeeMasterPage.php"; 	
?>
