<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] <3)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$usernat = trim(array_key_exists("Usernat",$_GET)?$_GET["Usernat"]:"");
$userrole = trim(array_key_exists("role",$_GET)?$_GET["role"]:"");

$search = trim(array_key_exists("search",$_GET)?$_GET["search"]:"");
$selsearch = trim(array_key_exists("searchselect",$_GET)?$_GET["searchselect"]:"");

if(((strlen($usernat) != 0) && (strlen($usernat) != 10)) || ((strlen($usernat) == 10) && ctype_digit($usernat) == false))
	MBox_Redirect_Die("ورودی نامعتبر","showAllPersons.php?search=".$search."&searchselect=".$selsearch);

$page = "تعیین سطح دسترسی سیستم";
$cnt = "";

$roles = Select("select * from systemroles");
$options = "";
for($i = 0 ; $i < count($roles);$i++)
{
	if($roles[$i]["id"] == $userrole)
		$selected = "selected";
	else
		$selected = "";
	$options .= "<option ".$selected." value='".$roles[$i]["id"]."'>".$roles[$i]["RoleName"]."</option>";
}
$cnt = "<style>form input[type=text]{border-radius:2px;border:1px solid #ababab;} .cnt{height:600px;} td{border:none} .lw{direction:ltr;}</style>";
				
$cnt = $cnt. "<form method='post' action='../../controllers/Controller.php'><div><table>";
if(array_key_exists("search",$_GET))
{
	$cnt = $cnt .'<input value="'.$search.'" type="hidden" name="search" />';
$cnt = $cnt .'<input value="'.$selsearch.'" type="hidden" name="searchselect" />';	
}
			
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">کد ملی : </label></td><td> <input value="'.$usernat.'" type="text" name="natcode" class="lw" /></td></div></tr>';
$cnt = $cnt .'<tr><div class="cl"><td><label class="lb">سطح دسترسی</label></td><td><select name="role">'.$options.'</select></td></div></tr>';
$cnt = $cnt .'<tr><td><div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="setAccessLevel_admin">ثبت</button></div><td></tr>';
if(array_key_exists("search",$_GET))
{
	$cnt = $cnt."</div><br><a style='padding:3px 5px;color:white;background-color:#00cc99;' 
	href='../employees/showAllPersons.php?search=".$search."&searchselect=".$selsearch."'>بازگشت به لیست</a></div>";
}
$cnt = $cnt.'</table></div>';

$cnt = $cnt.'</form>';

include "adminMasterPage.php"; 	
?>
