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
$page = "خاندان";
$csslink = "<link rel='stylesheet' href='../../css/tree.css'>";

$cnt = "";



//---------------------------------------------------------------------------------------------------------------------------------------------
$str = "";
function RecShajareh($id,$list,$depth)
{
	$depth++;
	global $str;
	$rec = searchInList($id,$list);
	
	if(($rec != null) && ($depth < 10))
	{
		$str .="<li>".$rec["fname"]." ".$rec["lname"]."<ul>";
	
		RecShajareh($rec["fatherid"],$list,$depth);
		RecShajareh($rec["motherid"],$list,$depth);
	
		$str .="</ul></li>";
	}
}
function RecNavade($id,$list,$depth)
{
	$depth++;
	global $str;
	$rec = searchInList($id,$list);
	
	if(($rec != null) && ($depth < 10))
	{
		$str .="<li>".$rec["fname"]." ".$rec["lname"]."<ul>";
		for($i=0;$i<count($list);$i++)
		{
			if(($list[$i]["fatherid"] == $id) || ($list[$i]["motherid"] == $id))
				RecNavade($list[$i]["id"],$list,$depth);
		}
	
		$str .="</ul></li>";
	}
}
function searchInList($id,$list)
{
	for($i=0;$i<count($list);$i++)
	{
		if($list[$i]["id"] == $id)
			return $list[$i];
	}
	return null;
}
//---------------------------------------------------------------------------------------------------------------------------------------------
$style="*{direction:rtl;}.division{border:3px solid #344556;border-radius:0 0 20px 20px;padding:10px;margin-bottom:30px;}.parag{padding:4px;background-color:#344556;color:white}";

$cnt .= "<div>";
$res = Select("call getParentsDetail(".$userid.")");
$person = searchInList($userid,$res);


if(count($res) > 1)
{
	$cnt .= "<p class='parag'>اجداد</p><div class='division'><p class='tree'>".$person["fname"]." ".$person["lname"]."</p><ul class='tree'>";
	RecShajareh($person["fatherid"],$res,0);
	RecShajareh($person["motherid"],$res,0);
	$cnt .= $str;
	$cnt .= "<ul></div>";
}


$str = "";		

$res = Select("call getChildDetail(".$userid.")");
if(count($res) > 1)
{
	$cnt .= "<p class='parag'>نوادگان</p><div class='division'><p class='tree'>".$person["fname"]." ".$person["lname"]."</p><ul class='tree'>";
	for($i=0;$i<count($res);$i++)
	{
		if(($res[$i]["fatherid"] == $person["id"]) || ($res[$i]["motherid"] == $person["id"]))
			RecNavade($res[$i]["id"],$res,0);
	}
$cnt .= $str;			
$cnt .= "<ul></div>";	
}
	
$cnt = $cnt."</div><br><a style='padding:3px 5px;color:white;background-color:#00cc99;' href='showAllPersons.php?search=".$search."&searchselect=".$selsearch."'>بازگشت به لیست</a></div>";

include "employeeMasterPage.php"; 	
?>
