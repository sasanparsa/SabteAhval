	<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 3)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$page = "اطلاعات";
$cnt = "";

$res = Select("select count(*) as cnt from users union all
 select count(*) from users where roleid >= 2 union all select count(*) from users where roleid = 3");

$cnt = "";
				
$cnt = $cnt. "<div style='float:right'><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد کاربران :  </label> <span>'.$res[0]["cnt"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد کارمندان : </label> <span>'.$res[1]["cnt"].'</span></div>';			
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد ادمین ها :</label> <span>'.$res[2]["cnt"].'</span></div>';			
$cnt = $cnt.'</div>';
include "adminMasterPage.php"; 	
?>
