<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$search = trim(array_key_exists("search",$_GET)?$_GET["search"]:"");
$selsearch = trim(array_key_exists("searchselect",$_GET)?$_GET["searchselect"]:"");
$strsel = $selsearch;
$selsearch = explode("s",$selsearch);
unset($selsearch[0]);
if(count($selsearch) != 0)
{
	if(count($selsearch) == 0)
		MBox_Redirect_die("ورودی نا معتبر","showAllPersons.php");
	for($i = 1;$i < count($selsearch);$i++)
		if(ctype_digit($selsearch[$i]) == false)
			MBox_Redirect_die("ورودی نا معتبر","showAllPersons.php");
}

$marrysearch = "";
$link="";
if(array_key_exists("marrysearch",$_GET) == true)
{
	$marrysearch = $_GET["marrysearch"];
	$link = "<a style='padding:3px 5px;color:white;background-color:#00cc99;' href='showAllMarries.php?msearch=".$marrysearch."'>بازگشت به لیست ازدواج ها</a><br><br>";
}
$fullname = "";
$chk1 = "";
if(in_array("1",$selsearch))
{
	$fullname = " or concat(u1.fname,' ',u1.lname) like N'%".$search."%' ";
	$chk1 = "checked";
}
$natCode = "";
$chk3 = "";
if(in_array("3",$selsearch))
{
	$natCode = " or u1.natCode like N'%".$search."%' ";
	$chk3 = "checked";
}
$shomareShenasname = "";
$chk4 = "";
if(in_array("4",$selsearch))
{
	$shomareShenasname = " or u1.shomareShenasname like N'%".$search."%' ";
	$chk4 = "checked";
}
$email = "";
$chk5 = "";
if(in_array("5",$selsearch))
{
	$email = " or u1.email like N'%".$search."%' ";
	$chk5 = "checked";
}
$tel = "";
$chk6 = "";
if(in_array("6",$selsearch))
{
	$tel = " or u1.tel like N'%".$search."%' ";
	$chk6 = "checked";
}
$address = "";
$chk7 = "";
if(in_array("7",$selsearch))
{
	$address = " or u1.address like N'%".$search."%' ";
	$chk7 = "checked";
}
$fnat = "";
$chk8 = "";
if(in_array("8",$selsearch))
{
	$fnat = " or u3.natCode like N'%".$search."%' ";
	$chk8 = "checked";
}
$mnat = "";
$chk9 = "";
if(in_array("9",$selsearch))
{
	$mnat = " or u4.natCode like N'%".$search."%' ";
	$chk9 = "checked";
}
$bdate = "";
$chk10 = "";
if(in_array("10",$selsearch))
{
	$bdate = " or u1.BirthDate like N'%".$search."%' ";
	$chk10 = "checked";
}
$ddate = "";
$chk11 = "";
if(in_array("11",$selsearch))
{
	$ddate = " or u1.DeathDate like N'%".$search."%' ";
	$chk11 = "checked";
}
$sadere = "";
$chk12 = "";
if(in_array("12",$selsearch))
{
	$sadere = " or u1.Sadereh like N'%".$search."%' ";
	$chk12 = "checked";
}
$jensiat = "";
$chk13 = "";
if(in_array("13",$selsearch))
{
	$jensiat = " or (CASE WHEN u1.Jensiat=0 THEN 'زن' else 'مرد' end like N'%".$search."%') ";
	$chk13 = "checked";
}
$sath = "";
if($_SESSION["roleid"] >= 3)
{
	$chk14 = "";
	if(in_array("14",$selsearch))
	{
		$sath = " or systemroles.rolename like N'%".$search."%' ";
		$chk14 = "checked";
	}
}


$jscript = '$(function(){ $(".confirm").on("click", function () {return confirm("آیا مطمعنید؟");});
	$(".w1,.w2,.w3").each(function(){
		$(this).css("width","1200");
	});
	$("input[id^=sel]").each(function(){
		id = $(this).attr("id").substring(3);
		searchsel = $("#searchselect");
		if ($(this).prop("checked")==true){ 
			searchsel.val(searchsel.val() + "s" + id.toString());
		}
		else
		{
			searchsel.val(searchsel.val().replace("s" + id.toString(),"")); 
		}
	});
	$("input[id^=sel]").on("click", function (){
		id = $(this).attr("id").substring(3);
		searchsel = $("#searchselect");
		if ($(this).prop("checked")==true){ 
			searchsel.val(searchsel.val() + "s" + id.toString());
		}
		else
		{
			searchsel.val(searchsel.val().replace("s" + id.toString(),"")); 
		}
	});
});';
$q = "select u1.*,concat(u1.fname,' ',u1.lname) as fullname,u2.natCode as empnat,concat(u2.fname,' ',u2.lname) as empname,systemroles.rolename as rolename
 from users u1 left outer join users u2 on u1.employeeid = u2.id left outer join users u3 on u1.fatherid = u3.id left outer join users u4 on u1.motherid = u4.id
 left outer join systemroles on u1.roleid = systemroles.id"
 .(count($selsearch) != 0 ? " where 1=0 ":"").$natCode.$shomareShenasname.$email.$tel.$address.$fnat.$mnat.$bdate.$ddate.$sadere.$jensiat.$sath.$fullname;
// echo $q;

$persons = Select($q);
$style = 'td .aa{color:white;padding:2px 5px;border:1px solid white;border-radius:4px;} td .aa:hover{border:1px solid black;}';
$page = "کاربران";
$cnt = "";
$cnt = "<style>form input[type=text]{width:300px;border-radius:2px;border:1px solid #ababab;padding:5px;} .lw{direction:ltr;}</style>";

$cnt = $cnt. "<form method='get' action='showAllPersons.php'>";
$cnt .= "<div><span style='width:100%;margin:auto'>".$link."<input type='text' name='search' value='".$search."' placeholder='متن جستجو را وارد کنید...'  /> 
<input type='hidden' value='' name='searchselect' id='searchselect' /><button class='button' name='showAllPersons_searchbtn'>جستجو</button></span></div></form><br>
<input type='checkbox' ".$chk1."  id='sel1'>نام و نام خانوادگی</input>
<input type='checkbox' ".$chk3."  id='sel3'>کدملی</input>
<input type='checkbox' ".$chk4."  id='sel4'>شماره شناسنامه</input>
<input type='checkbox' ".$chk5."  id='sel5'>ایمیل</input>
<input type='checkbox' ".$chk6."  id='sel6'>تلفن</input>
<input type='checkbox' ".$chk7."  id='sel7'>آدرس</input>
<input type='checkbox' ".$chk8."  id='sel8'>کدملی پدر</input>
<input type='checkbox' ".$chk9."  id='sel9'>کدملی مادر</input>
<input type='checkbox' ".$chk10."  id='sel10'>تاریخ تولد</input>
<input type='checkbox' ".$chk11."  id='sel11'>تاریخ فوت</input>
<input type='checkbox' ".$chk12."  id='sel12'>صادره</input>
<input type='checkbox' ".$chk13."  id='sel13'>جنسیت</input>";
if($_SESSION["roleid"] >= 3)
{
	$cnt .= "<input type='checkbox' ".$chk14."  id='sel14'>سطح</input><br><br>";
}


$cnt .= "<div style='text-align:center;'><table style='width:100%;padding:0 4px;'><thead><th>نام و نام خانوادگی</th><th>کد ملی</th><th>ش.ش</th><th>
تاریخ تولد</th><th>تاریخ فوت</th><th>جنسیت</th>".($_SESSION["roleid"] >= 3 ? "<th>سطح</th>":"").($_SESSION["roleid"] >= 3 ? "<th>کارمند</th>":"")."
<th></th><th></th><th></th><th></th><th></th><th></th>".($_SESSION["roleid"] >= 3 ? "<th></th>":"")."</thead>";
for($i = 0 ; $i < count($persons);$i++)
{
	$jensiat = $persons[$i]["Jensiat"];
	if($jensiat == 0) $jensiat = "زن";else$jensiat = "مرد";
	$cnt .= "<tr><td>".$persons[$i]["fullname"]."</td><td>
	<a style='text-decoration:underline' href='showAllMarries.php?msearch=".$persons[$i]["natCode"]."'>".$persons[$i]["natCode"]."</a></td>
	<td>".$persons[$i]["shomareShenasname"]."</td>
	<td>".$persons[$i]["BirthDate"]."</td><td>".$persons[$i]["DeathDate"]."</td><td>".$jensiat."</td>";
	if($_SESSION["roleid"] >= 3)
	{
		$cnt .= "<td>".$persons[$i]["rolename"]."</td>";
		$cnt .= "<td><table><tr><td style='border:none'>".$persons[$i]["empnat"]."</td></tr><tr><td style='border:none'>".$persons[$i]["empname"]."</td></tr></table></td>";
	}
	$cnt .= "<td><a style='background-color:red;' class='confirm aa' href='../../controllers/Controller.php?deleteUserid=".$persons[$i]["id"]."&search=".$search."&selectsearch=".$strsel."'>حذف</a></td>
	<td><a class='aa' style='background-color:#123499;'  href='showPersonProfile.php?Userid=".$persons[$i]["id"]."&search=".$search."&selectsearch=".$strsel."'>نمایش پروفایل</a></td>
	<td><a class='aa' style='background-color:#009999;' href='personRelations.php?Userid=".$persons[$i]["id"]."&search=".$search."&selectsearch=".$strsel."'>وابستگان</a></td>
	<td><a class='aa' style='background-color:#336699;'  href='shajarehPerson.php?Userid=".$persons[$i]["id"]."&search=".$search."&selectsearch=".$strsel."'>شجره</a></td>
	<td><a class='aa' style='background-color:#625678;' href='shajarehTree.php?Userid=".$persons[$i]["id"]."&search=".$search."&selectsearch=".$strsel."'>خاندان</a></td>
	<td><a class='aa' style='background-color:#339933;' href='editPerson.php?Userid=".$persons[$i]["id"]."&search=".$search."&selectsearch=".$strsel."'>ویرایش</a></td>";
	
	if($_SESSION["roleid"] >= 3)
	{
		$cnt .= "<td><a class='aa' style='background-color:#999966;'  
		href='../admins/setAccessLevel.php?Usernat=".$persons[$i]["natCode"]."&role=".$persons[$i]["Roleid"]."&search=".$search."&searchselect=".$strsel."'>
		تعیین سطح کاربری</a></td>";
	}
	
	$cnt .= "</tr>";
}
$cnt .= "</table></div>";
$cnt = $cnt.'</form>';
include "employeeMasterPage.php"; 	
?>
