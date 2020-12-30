<?php
session_start();
require "../../controllers/Database.php";
require "../../controllers/Utilities.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$search = trim(array_key_exists("search",$_GET)?$_GET["search"]:"");
$selsearch = trim(array_key_exists("selectsearch",$_GET)?$_GET["selectsearch"]:"");

if(array_key_exists( "Userid",$_GET) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","showAllPersons.php?search=".$search."&searchselect=".$selsearch);

$userid = trim($_GET["Userid"]);

if(($userid < 0) || (strlen($userid) == 0))
	MBox_Redirect_Die("دسترسی نامعتبر","showAllPersons.php?search=".$search."&searchselect=".$selsearch);


$jensiat = Select("select Jensiat from users where id = ".$userid)[0]["Jensiat"];
$page = "وابستگان";
$cnt = "<div  style='padding:3px;'><br><a style='padding:3px 5px;color:white;background-color:#00cc99;' href='showAllPersons.php?search=".$search."&searchselect=".$selsearch."'>بازگشت به لیست</a>";
//-----------------------------pedarmadar------------------------------------------------------------------------------------------------------------------------
$res = Select("select u1.*, concat(u1.fname,' ',u1.lname)as 'fullname',concat(u2.fname,' ',u2.lname) as 'fathername',concat(u3.fname,' ',u3.lname) as 'mothername',
u2.natCode as 'fathernat',u3.natCode as 'mothernat' 
from users u1 left outer join users u2 on u1.fatherid = u2.id left outer join users u3 on u1.motherid = u3.id 
where u1.id in( select motherid from users where id =".$userid." UNION select fatherid from users where id =".$userid." ) order by u1.Jensiat desc ");

$cnt .= "<div><style>table{width:100%;}</style>";
$cnt = $cnt ."<fieldset><legend>پدر و مادر </legend>";
$cnt = $cnt."<table><thead><th>نام کامل</th><th>کد ملی</th><th>تاریخ تولد</th><th>تاریخ فوت</th><th>صادره</th><th>شماره شناسنامه</th><th>وضعیت</th><th>نسبت</th><th>پدر</th><th>کد ملی پدر</th><th>مادر</th><th>کد ملی مادر</th><th>عکس</th></thead>";				
for($i = 0;$i < count($res);$i++)
{
	if($res[$i]["Jensiat"] == "0")
		$type = "مادر";
	else
		$type = "پدر";
	
	if($res[$i]["isAlive"] == "0")
		$status = "فوت شده";
	else
		$status = "زنده";
	$cnt .= "<tr>";
	$cnt .= "<td>".$res[$i]["fullname"]."</td>";
	$cnt .= "<td>".$res[$i]["natCode"]."</td>";
	$cnt .= "<td>".$res[$i]["BirthDate"]."</td>";
	$cnt .= "<td>".$res[$i]["DeathDate"]."</td>";
	$cnt .= "<td>".$res[$i]["Sadereh"]."</td>";
	$cnt .= "<td>".$res[$i]["shomareShenasname"]."</td>";
	$cnt .= "<td>".$status."</td>";
	$cnt .= "<td>".$type."</td>";
	$cnt .= "<td>".$res[$i]["fathername"]."</td>";
	$cnt .= "<td>".$res[$i]["fathernat"]."</td>";
	$cnt .= "<td>".$res[$i]["mothername"]."</td>";
	$cnt .= "<td>".$res[$i]["mothernat"]."</td>";
	$cnt .= "<td><img src='../../images/site/".($res[$i]["picture"] != ""?$res[$i]["picture"]:GetDefaultPicturePath($res[$i]["Jensiat"]))."' width='100' height='100'/></td>";
	$cnt .= "</tr>";
}
$cnt = $cnt ."</table></fieldset>";
			
$cnt = $cnt.'</div>';
//-----------------------------baradar-khahar----------------------------------------------------------------------------------------------------------------
$res = Select("select *,CONCAT(fname,' ',lname) as 'fullname' from users where (motherid in(select motherid from users where id = ".$userid.") or fatherid in (select fatherid from users where id = ".$userid.")) and id !=".$userid);

$cnt .= "<div>";
$cnt = $cnt ."<fieldset><legend>برادر و خواهر </legend>";
$cnt = $cnt."<table style='width:100%'><thead><th>نام کامل</th><th>کد ملی</th><th>تاریخ تولد</th><th>تاریخ فوت</th><th>صادره</th><th>شماره شناسنامه</th><th>وضعیت</th><th>نسبت</th><th>عکس</th></thead>";				
for($i = 0;$i < count($res);$i++)
{
	if($res[$i]["Jensiat"] == "0")
		$type = "خواهر";
	else
		$type = "برادر";
	
	if($res[$i]["isAlive"] == "0")
		$status = "فوت شده";
	else
		$status = "زنده";
	$cnt .= "<tr>";
	$cnt .= "<td>".$res[$i]["fullname"]."</td>";
	$cnt .= "<td>".$res[$i]["natCode"]."</td>";
	$cnt .= "<td>".$res[$i]["BirthDate"]."</td>";
	$cnt .= "<td>".$res[$i]["DeathDate"]."</td>";
	$cnt .= "<td>".$res[$i]["Sadereh"]."</td>";
	$cnt .= "<td>".$res[$i]["shomareShenasname"]."</td>";
	$cnt .= "<td>".$status."</td>";
	$cnt .= "<td>".$type."</td>";
	$cnt .= "<td><img src='../../images/site/".($res[$i]["picture"] != ""?$res[$i]["picture"]:GetDefaultPicturePath($res[$i]["Jensiat"]))."' width='100' height='100'/></td>";
	$cnt .= "</tr>";
}
$cnt = $cnt ."</table></fieldset>";
			
$cnt = $cnt.'</div>';
//-----------------------------farzandan----------------------------------------------------------------------------------------------------------------
$res = Select("select *,concat(fname,' ',lname) as 'fullname' from users where motherid = ".$userid." or fatherid =".$userid);

$cnt .= "<div>";
$cnt = $cnt ."<fieldset><legend>فرزندان </legend>";
$cnt = $cnt."<table style='width:100%'><thead><th>نام کامل</th><th>کد ملی</th><th>تاریخ تولد</th><th>تاریخ فوت</th><th>صادره</th><th>شماره شناسنامه</th><th>وضعیت</th><th>نسبت</th><th>عکس</th></thead>";				
for($i = 0;$i < count($res);$i++)
{
	if($res[$i]["Jensiat"] == "0")
		$type = "دختر";
	else
		$type = "پسر";
	
	if($res[$i]["isAlive"] == "0")
		$status = "فوت شده";
	else
		$status = "زنده";
	$cnt .= "<tr>";
	$cnt .= "<td>".$res[$i]["fullname"]."</td>";
	$cnt .= "<td>".$res[$i]["natCode"]."</td>";
	$cnt .= "<td>".$res[$i]["BirthDate"]."</td>";
	$cnt .= "<td>".$res[$i]["DeathDate"]."</td>";
	$cnt .= "<td>".$res[$i]["Sadereh"]."</td>";
	$cnt .= "<td>".$res[$i]["shomareShenasname"]."</td>";
	$cnt .= "<td>".$status."</td>";
	$cnt .= "<td>".$type."</td>";
	$cnt .= "<td><img src='../../images/site/".($res[$i]["picture"] != ""?$res[$i]["picture"]:GetDefaultPicturePath($res[$i]["Jensiat"]))."' width='100' height='100'/></td>";
	$cnt .= "</tr>";
}
$cnt = $cnt ."</table></fieldset>";
			
$cnt = $cnt.'</div>';
//-----------------------------hamsar----------------------------------------------------------------------------------------------------------------
if($jensiat == 1)
{
	$oncolname = "womanpersonid";
	$wherecolname = "manpersonid";
}
else
{
	$oncolname = "manpersonid";
	$wherecolname = "womanpersonid";
}
$res = Select("select *,concat(fname,' ',lname) as 'fullname' from marryinfo m left outer join users u on m.".$oncolname." = u.id where ".$wherecolname." =".$userid);
$cnt .= "<div>";
$cnt = $cnt ."<fieldset><legend>همسر </legend>";
$cnt = $cnt."<table style='width:100%'><thead><th>نام کامل</th><th>کد ملی</th><th>تاریخ تولد</th><th>تاریخ فوت</th>
<th>صادره</th><th>شماره شناسنامه</th><th>وضعیت</th><th>عکس</th><th>ازدواج</th><th>طلاق</th></thead>";				
for($i = 0;$i < count($res);$i++)
{
	
	if($res[$i]["isAlive"] == "0")
		$status = "فوت شده";
	else
		$status = "زنده";
	$cnt .= "<tr>";
	$cnt .= "<td>".$res[$i]["fullname"]."</td>";
	$cnt .= "<td>".$res[$i]["natCode"]."</td>";
	$cnt .= "<td>".$res[$i]["BirthDate"]."</td>";
	$cnt .= "<td>".$res[$i]["DeathDate"]."</td>";
	$cnt .= "<td>".$res[$i]["Sadereh"]."</td>";
	$cnt .= "<td>".$res[$i]["shomareShenasname"]."</td>";
	$cnt .= "<td>".$status."</td>";
	$cnt .= "<td><img src='../../images/site/".($res[$i]["picture"] != ""?$res[$i]["picture"]:GetDefaultPicturePath($res[$i]["Jensiat"]))."' width='100' height='100'/></td>";
	$cnt .= "<td>".$res[$i]["marrydate"]."</td>";
	$cnt .= "<td>".$res[$i]["talaghdate"]."</td>";
	$cnt .= "</tr>";
}
$cnt = $cnt ."</table></fieldset>";
			
$cnt = $cnt."</div>";
//-----------------------------------------------------------------------------------------------------------------------------------------------------------

$cnt .= '</div>';
include "employeeMasterPage.php"; 	
?>
