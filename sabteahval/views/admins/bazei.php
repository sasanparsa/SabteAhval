	<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 3)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$date1 = trim(array_key_exists("date1",$_GET)?$_GET["date1"]:"");
$date2 = trim(array_key_exists("date2",$_GET)?$_GET["date2"]:"");
if(strlen($date1) == 0)
	$date1 = "1300/01/01";
else if(preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$date1)== false )
	MBox_Redirect_Die("ورودی اشتباه","bazei.php");
if(strlen($date2) == 0)
	$date2 = "1400/01/01";
else if(preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$date2)== false )
	MBox_Redirect_Die("ورودی اشتباه","bazei.php");

if($date1 > $date2)
	MBox_Redirect_Die("خطا : تاریخ دوم کوچکتر است","bazei.php");
$page = "آمار بازه ای";
$cnt = "";


$res = Select("
 select count(*) as cnt from users where birthdate between '".$date1."' and '".$date2."' union all
 select count(*)        from users where deathdate between '".$date1."' and '".$date2."' union all
 select count(*) from marryinfo where marrydate between '".$date1."' and '".$date2."' union all
 select count(*) from marryinfo where talaghdate between '".$date1."' and '".$date2."'"
 );
$cnt = "";


$cnt = $cnt. "<form method='get' action='bazei.php'><div>
<style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<div class="cl" ><label class="lb">از تاریخ : </label> <input style="direction:ltr;" value="'.$date1.'" type="text" name="date1"/></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">تا تاریخ : </label> <input style="direction:ltr;" value="'.$date2.'" type="text" name="date2"/></div>';
$cnt = $cnt .'<div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="changepass_form_changepass_btn">دریافت اطلاعات</button></div></form>';
$cnt = $cnt.'</div>';


$cnt = $cnt. "<div style='float:right'><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}
.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد متولدین در این بازه : </label> <span>'.$res[0]["cnt"].'</span></div>';
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد فوت شده در این بازه : </label> <span>'.$res[1]["cnt"].'</span></div>';			
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد ازدواج ها در این بازه : </label> <span>'.$res[2]["cnt"].'</span></div>';			
$cnt = $cnt .'<div class="cl"><label class="lb">تعداد طلاق ها در این بازه : </label> <span>'.$res[3]["cnt"].'</span></div>';	
$cnt = $cnt.'</div>';
include "adminMasterPage.php"; 	
?>
