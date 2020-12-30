<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$msearch = trim(array_key_exists( "msearch",$_GET)?$_GET["msearch"]:"");


$marries = Select("select m.*,u1.natCode as mnat,u2.natCode as wnat,concat(u1.fname,' ',u1.lname) as 'mfull',concat(u2.fname,' ',u2.lname) as 'wfull',
u3.natCode as empnat,concat(u3.fname,' ',u3.lname) as empname
 from marryinfo m left outer join users u1 on m.manpersonid = u1.id left outer join users u2 on m.womanpersonid = u2.id left outer join users u3 on u1.employeeid = u3.id
where u1.natCode like N'%".$msearch."%' or u2.natCode like N'%".$msearch."%' or  concat(u1.fname,' ',u1.lname) like N'%".$msearch."%' or 
 concat(u2.fname,' ',u2.lname) like N'%".$msearch."%'");
 
$page = "ازدواج ها";
$jscript = '$(function(){ $(".confirm").on("click", function () {return confirm("آیا مطمعنید؟");});})';
$style = '.aa{color:white;padding:2px 5px;border:1px solid white;border-radius:4px;} td .aa:hover{border:1px solid black;}';
$cnt = "";
$cnt = "<style>form input[type=text]{width:300px;border-radius:2px;border:1px solid #ababab;padding:5px;} .lw{direction:ltr;}</style>";
				
$cnt = $cnt. "<form method='get' action='showAllMarries.php'>";
$cnt .= "<div><span style='width:100%;margin:auto'><input type='text' name='msearch' value='".$msearch."' placeholder='جستجو بر اساس نام یا کد ملی'  /> 
<button class='button' name='showAllMarries_searchbtn'>جستجو</button></span></div><br>";

$cnt .= "<div style='text-align:center;'><table style='width:100%;padding:0 4px;'><thead><th>نام و نام خانوادگی مرد</th><th>کدملی مرد</th><th>نام و نام خانوادگی زن</th>
<th>کدملی زن</th><th>ازدواج</th><th>طلاق</th>".($_SESSION["roleid"] >= 3 ? "<th>کارمند</th>":"")."<th></th><th></th></thead>";
for($i = 0 ; $i < count($marries);$i++)
{
	$cnt .= "<tr>
	<td>".$marries[$i]["mfull"]."</td><td><a style='text-decoration:underline' href='showAllPersons.php?marrysearch=".$msearch."&search=".$marries[$i]["mnat"]."&searchselect=s3'>".$marries[$i]["mnat"]."</a></td><td>".$marries[$i]["wfull"]."</td>
	<td><a style='text-decoration:underline' href='showAllPersons.php?marrysearch=".$msearch."&search=".$marries[$i]["wnat"]."&searchselect=s3'>".$marries[$i]["wnat"]."</a></td><td>".$marries[$i]["marrydate"]."</td><td>".$marries[$i]["talaghdate"]."</td>";
	if($_SESSION["roleid"] >= 3)
	{
		$cnt .= "<td><table><tr><td style='border:none'>".$marries[$i]["empnat"]."</td></tr><tr><td style='border:none'>".$marries[$i]["empname"]."</td></tr></table></td>";
	}
	$cnt .= "<td ><a class='confirm aa' style='background-color:red;' href='../../controllers/Controller.php?deleteMarryid=".$marries[$i]["id"]."&msearch=".$msearch."'>حذف</a></td>
	<td ><a class='aa' style='background-color:#339933;' href='editMarry.php?Marryid=".$marries[$i]["id"]."&msearch=".$msearch."'>ویرایش</a></td>
	</tr>";
}

$cnt .= "</table></div>";
$cnt = $cnt.'</form>';
include "employeeMasterPage.php"; 	
?>
