<?php
session_start();
require "../../controllers/Database.php";
require "../../controllers/Utilities.php";

if(array_key_exists( "userid",$_SESSION) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$page = "تغییر رمز عبور";
$cnt = "";
				
$cnt = $cnt. "<form method='POST' action='../../controllers/Controller.php'><div style='float:right'><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<div class="cl"><label class="lb">رمز عبور فعلی : </label> <input type="text" name="oldpass"/></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">رمز عبور جدید : </label> <input type="text" name="newpass"/></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">تکرار رمز عبور جدید : </label> <input type="text" name="newpass2"/></div>';
$cnt = $cnt .'<div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="changepass_form_changepass_btn">ثبت</button></div></form>';



$cnt = $cnt.'</div>';
include "userMasterPage.php"; 	
?>
