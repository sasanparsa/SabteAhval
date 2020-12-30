<?php
session_start();
require "../../controllers/Database.php";
require "../../controllers/Utilities.php";

if(array_key_exists( "userid",$_SESSION) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$data = Select("select tel,address,email from users where id = ".$_SESSION["userid"]);

if($data === null || count($data) == 0)
	MBox_Redirect_Die("اطلاعاتی یافت نشد","profile.php");
else 
	$data = $data[0];

$page = "ویرایش";
$cnt = "";
				
$cnt = $cnt. "<form method='POST' action='../../controllers/Controller.php'><div style='float:right'><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<input type="hidden" name="id" value ="'.$_SESSION["userid"].'"/>';
$cnt = $cnt .'<div class="cl"><label class="lb">تلفن : </label> <input style="width:180px;direction:ltr;" type="text" name="tel" value="'.$data["tel"].'"/></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">ایمیل : </label> <input style="width:180px;direction:ltr;" type="text" name="email" value="'.$data["email"].'"/></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">آدرس : </label> <textarea style="width:180px;height:200px;" name="address">'.$data["address"].'</textarea></div>';
$cnt = $cnt .'<div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="editProfile_user">ویرایش</button></div></form>';



$cnt = $cnt.'</div>';
include "userMasterPage.php"; 	
?>
