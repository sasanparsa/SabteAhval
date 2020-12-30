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


$page = "شجره نامه کاربر";
$cnt = "";

$res = Select("SELECT T2.id, T2.natCode,concat(T2.fname,' ',T2.lname) as 'fullname' FROM ( SELECT @r AS _id, (SELECT @r := fatherid 
				FROM users WHERE id = _id) AS parent_id, @l := @l + 1 AS lvl FROM (SELECT @r := ".$userid.", @l := 0) vars, users h 
				WHERE @r <> 0) T1 JOIN users T2 ON T1._id = T2.id ORDER BY T1.lvl DESC");


$cnt = "<div>";
				
$cnt = $cnt. "<div><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
for($i = 0 ; $i < count($res)-1;$i++)
{
	$cnt = $cnt .'<div class="cl"><span>'.$res[$i]["fullname"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:lightgreen">'.$res[$i]["natCode"].'</span></div>';
	$cnt = $cnt."<div style='width:400px;margin-right:30px;margin-bottom:5px;'><span style='width:200px;margin:0 auto;text-align:center;'><img style='display:block;margin:0 auto;' src='../../images/site/site_uparrow.png' width='12' height='12'/></span></div>";
}
$cnt = $cnt .'<div class="cl"><span>'.$res[count($res)-1]["fullname"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:lightgreen">'.$res[count($res)-1]["natCode"].'</span></div>';
				
$cnt = $cnt."</div><br><a style='padding:3px 5px;color:white;background-color:#00cc99;' href='showAllPersons.php?search=".$search."&searchselect=".$selsearch."'>بازگشت به لیست</a></div>";
include "employeeMasterPage.php"; 	
?>
