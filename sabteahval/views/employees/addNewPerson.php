<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$page = "ثبت اطلاعات فرد جدید";
$cnt = "";

$cnt = "<div style='float:left;margin:30px 0 0 30px;'><img style='border-radius:5px;border:6px solid #abcdef' src='../../images/site/def.png' hight='250' width='250'/>
<br><form method='post' action='../../controllers/Controller.php' enctype='multipart/form-data'><input type='file' name='uppic' /></div>";
$cnt .= "<style>textarea,input[type=text]{border-radius:2px;border:1px solid #ababab;padding:4px;} .cnt{height:600px;} td{border:none} .lw{direction:ltr;}</style>";
				
$cnt = $cnt. "<div><table>";				
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">نام : </label></td><td> <input type="text" name="fname" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">نام خانوادگی : </label></td><td> <input type="text" name="lname" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی : </label></td> <td><input type="text" name="natcode" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">شماره شناسنامه : </label></td> <td><input type="text" name="shsh" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">صادره : </label></td><td> <input  type="text"name="sadere" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تاریخ تولد : </label></td><td> <input type="text" name="bdate" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تاریخ فوت : </label></td><td> <input type="text" name="ddate" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی پدر : </label> </td><td><input type="text" name="fnat" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی مادر : </label> </td><td><input type="text" name="mnat" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">ایمیل : </label> </td><td><input type="text" name="email" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">تلفن : </label> </td><td><input type="text" name="tel" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">رمز : </label> </td><td><input type="text" name="pass" class="lw"/></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">آدرس : </label> </td><td><textarea width="300" name="address"></textarea></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">جنسیت : </label> </td><td><select name="jensiat" ><option value="1">مرد</option><option value="0" >زن</option></select></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">وضعیت : </label> </td><td><select name="isalive"><option value="1">زنده</option><option value="0">فوت شده</option></select></td></div></tr>';
$cnt = $cnt .'<tr><td><div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="addNewPerson_btn">ثبت</button></div><td></tr>';
$cnt = $cnt.'</table></div>';
$cnt = $cnt.'</form>';
include "employeeMasterPage.php"; 	
?>
