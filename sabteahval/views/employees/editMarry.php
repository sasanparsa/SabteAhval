<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$msearch = trim(array_key_exists( "msearch",$_GET)?$_GET["msearch"]:"");

if(array_key_exists( "Marryid",$_GET) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","showAllMarries.php?msearch=".$msearch);

$marryid = trim($_GET["Marryid"]);
if(($marryid < 0) || (strlen($marryid) == 0))
	MBox_Redirect_Die("دسترسی نامعتبر","showAllMarries.php?msearch=".$msearch);



$marry = Select("select  m.id as id ,talaghdate,marrydate,u1.natCode as 'mannat',u2.natCode as 'womannat'
from marryinfo m left outer join users u1 on m.manpersonid = u1.id left outer join users u2 on m.womanpersonid = u2.id where m.id = ".$marryid)[0];




$page = "ویرایش اطلاعات ازدواج";
$cnt = "";

$cnt = "<style>form input[type=text]{border-radius:2px;border:1px solid #ababab;} .cnt{height:600px;} td{border:none} .lw{direction:ltr;}</style>";
				
$cnt = $cnt. "<form method='post' action='../../controllers/Controller.php'><div><table>";				
$cnt = $cnt .'<input value="'.$marry["id"].'" type="hidden" name="id" />';
$cnt = $cnt .'<input value="'.$msearch.'" type="hidden" name="msearch" />';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی مرد : </label></td><td> <input value="'.$marry["mannat"].'" type="text" name="mannat" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی زن : </label></td><td> <input value="'.$marry["womannat"].'" type="text" name="womannat" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تاریخ ازدواج : </label></td> <td><input value="'.$marry["marrydate"].'" type="text" name="marrydate" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تاریخ طلاق : </label></td> <td><input value="'.$marry["talaghdate"].'" type="text" name="talaghdate" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><td><div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="editMarryInfo_employee">ثبت</button></div><td></tr>';
$cnt = $cnt.'</table></div>';
$cnt = $cnt.'</form>';
include "employeeMasterPage.php"; 	
?>
