<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";
if(array_key_exists( "userid",$_SESSION) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");




$page = "پروفایل";
$cnt = "";

$res = Select("
select u1.*, CONCAT(u2.fname,' ',u2.lname) as 'momname' ,u2.natCode as 'momnat', CONCAT(u3.fname,' ' ,u3.lname) as 'dadname' ,u3.natCode as 'dadnat', systemroles.RoleName 
from users u1 left outer join users u2 on u1.motherid = u2.id left outer join users u3 on u1.fatherid = u3.id left outer join systemroles on u1.Roleid = systemroles.id
where u1.id = ".$_SESSION["userid"]);

if($res === null || count($res) == 0)
	MBox_Redirect_Die("اطلاعاتی یافت نشد","../../logout.php");
else 
	$res = $res[0];

if($res["Jensiat"] == "1")
	$jensiat = "مرد";
else
	$jensiat = "زن";

if($res["isAlive"] == "1")
	$vaziat = "زنده";
else
	$vaziat = "فوت شده";


$cnt = "<div style='float:left;margin:30px 0 0 30px;'><img style='border-radius:5px;border:6px solid #abcdef' 
src='../../images/site/".($res["picture"] != ""?$res["picture"]:GetDefaultPicturePath($res["Jensiat"]))."' hight='250' width='250'/></div>";
				
$cnt = $cnt. "<div style='float:right'><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<div class="cl"><label class="lb">نام : </label> <span>'.$res["fname"].'</span></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">نام خانوادگی : </label> <span>'.$res["lname"].'</span></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">کد ملی : </label> <span>'.$res["natCode"].'</span></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">شماره شناسنامه : </label> <span>'.$res["shomareShenasname"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">صادره : </label> <span>'.$res["Sadereh"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">جنسیت : </label> <span>'.$jensiat.'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">وضعیت : </label> <span>'.$vaziat.'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">تلفن : </label> <span>'.$res["Tel"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">ایمیل : </label> <span>'.$res["email"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">تاریخ تولد : </label> <span>'.$res["BirthDate"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">تاریخ وفات : </label> <span>'.$res["DeathDate"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">نقش  : </label> <span>'.$res["RoleName"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">پدر  : </label> <span>'.$res["dadname"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="lb">کد ملی پدر  : </label> <span>'.$res["dadnat"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">مادر  : </label> <span>'.$res["momname"].'</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="lb">کد ملی مادر  : </label> <span>'.$res["momnat"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">آدرس : </label> <span>'.$res["Address"].'</span></div>';
				
$cnt = $cnt.'</div>';
include "userMasterPage.php"; 	
?>
