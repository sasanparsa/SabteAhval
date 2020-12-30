<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$search = trim(array_key_exists("search",$_GET)?$_GET["search"]:"");
$selsearch = trim(array_key_exists("selectsearch",$_GET)?$_GET["selectsearch"]:"");

if(array_key_exists( "Userid",$_GET) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","showAllPersons.php?search=".$search."&searchselect=".$selsearch);

$userid = trim($_GET["Userid"]);

if(($userid < 0) || (strlen($userid) == 0))
	MBox_Redirect_Die("دسترسی نامعتبر","showAllPersons.php?search=".$search."&searchselect=".$selsearch);

$person = Select("select u1.*,u2.natCode as mnat,u3.natCode as fnat from users u1 left outer join users u2 on u1.motherid = u2.id
 left outer join users u3 on u1.fatherid = u3.id  where u1.id = ".$userid)[0];

$page = "ویرایش اطلاعات فرد";
$cnt = "";
$cnt = "<div style='float:left;margin:30px 0 0 30px;'><img style='border-radius:5px;border:6px solid #abcdef' src='../../images/site/".
($person["picture"] != ""?$person["picture"]:GetDefaultPicturePath($person["Jensiat"]))."' hight='250' width='250'/>
<br><form method='post' action='../../controllers/Controller.php' enctype='multipart/form-data'><input type='file' name='uppic' /></div>";
$cnt .= "<style>textarea,input[type=text]{border-radius:2px;border:1px solid #ababab;padding:4px;} .cnt{height:600px;} td{border:none} .lw{direction:ltr;}</style>";
				
$cnt = $cnt. "<br><a style='padding:3px 5px;color:white;background-color:#00cc99;' href='showAllPersons.php?search=".$search."&searchselect=".$selsearch."'>بازگشت به لیست</a>
<div><table>";				
$cnt = $cnt .'<input value="'.$person["id"].'" type="hidden" name="id" />';
$cnt = $cnt .'<input value="'.$search.'" type="hidden" name="search" />';
$cnt = $cnt .'<input value="'.$person["picture"].'" type="hidden" name="pic" />';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">نام : </label></td><td> <input value="'.$person["fname"].'" type="text" name="fname" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">نام خانوادگی : </label></td><td> <input value="'.$person["lname"].'" type="text" name="lname" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی : </label></td> <td><input value="'.$person["natCode"].'" type="text" name="natcode" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">شماره شناسنامه : </label></td> <td><input value="'.$person["shomareShenasname"].'" type="text" name="shsh" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">صادره : </label></td><td> <input value="'.$person["Sadereh"].'" type="text"name="sadere" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تاریخ تولد : </label></td><td> <input value="'.$person["BirthDate"].'" type="text" name="bdate" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تاریخ فوت : </label></td><td> <input value="'.$person["DeathDate"].'" type="text" name="ddate" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی پدر : </label> </td><td><input value="'.$person["fnat"].'" type="text" name="fnat" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی مادر : </label> </td><td><input value="'.$person["mnat"].'" type="text" name="mnat" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">ایمیل : </label> </td><td><input value="'.$person["email"].'" type="text" name="email" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تلفن : </label> </td><td><input value="'.$person["Tel"].'" type="text" name="tel" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">رمز : </label> </td><td><input value="'.$person["password"].'" type="text" name="pass" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">آدرس : </label> </td><td><textarea width="300" name="address">'.$person["Address"].'</textarea></td></div></tr>';
if($person["Jensiat"] == "0"){$zan="selected";$mard="";}else{$zan="";$mard="selected";}
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">جنسیت : </label> </td><td><select name="jensiat" ><option value="1" '.$mard.'>مرد</option><option value="0" '.$zan.'>زن</option></select></td></div></tr>';
if($person["isAlive"] == "1"){$zende="selected";$morde="";}else{$zende="";$morde="selected";}
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">وضعیت : </label> </td><td><select name="isalive"><option value="1" '.$zende.'>زنده</option><option value="0" '.$morde.'>فوت شده</option></select></td></div></tr>';
$cnt = $cnt .'<tr><td><div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="editPerson_employee">ویرایش</button></div><td></tr>';
$cnt = $cnt.'</table></div>';
$cnt = $cnt.'</form>';
include "employeeMasterPage.php"; 	
?>
