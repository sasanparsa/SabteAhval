	<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$page = "اطلاعات";
$cnt = "";

$res = Select("select count(*) as cnt from users where Employeeid = ".$_SESSION["userid"]." union all select count(*) from marryinfo where Employeeid = ".$_SESSION["userid"]);

$cnt = "";
				
$cnt = $cnt. "<div style='float:right'><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد افراد ثبت شده توسط شما : </label> <span>'.$res[0]["cnt"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد ازدواج ثبت توسط شما : </label> <span>'.$res[1]["cnt"].'</span></div>';			
$cnt = $cnt.'</div>';
include "employeeMasterPage.php"; 	
?>
