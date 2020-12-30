<?php

require "Utilities.php";
require "Database.php";
session_start();
//-----------login-----------------------------------------------------------------------------------------------------------------------------
if(array_key_exists( "login_form_login_btn",$_POST))
{
	if(KeyExists($_POST,array("natcode","password")) == false)
		MBox_Redirect_die("دسترسی نامعتبر","../login.html");
	$username = trim($_POST["natcode"]);
	$password = trim($_POST["password"]);
	
	if((strlen($username) != 10) ||(strlen($password) < 10)||(strlen($password) > 50) || (ctype_digit($username) == 0))
	{
		MBox_Redirect_die("خطا در داده ی ورودی","../login.html");
	}
	$res = Select("select * from Users where natCode = N'".$username."' and password = N'".$password."'");
	if(count($res) == 0)
	{
		MBox_Redirect_die("فردی با اطلاعات وارد شده وجود ندارد","../login.html");
	}
	else
	{
		$_SESSION["username"] = $username;
		$_SESSION["userid"] = (int)$res[0]["id"];
		$_SESSION["roleid"] = (int)$res[0]["Roleid"];
		$_SESSION["jensiat"] = (int)$res[0]["Jensiat"];
		
		Redirect("../views/users/profile.php",false);

	}
	die();
}
//-----------users---------------------------------------------------------------------------------------------------------------------------

if(array_key_exists("userid",$_SESSION) == false)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");
//-----------changepass---------------------------------------------------------------------------------------------------------------------------
if(array_key_exists("changepass_form_changepass_btn",$_POST))
{
	if(KeyExists($_POST,array("oldpass","newpass","newpass2")) == false)
		MBox_Redirect_die("دسترسی نامعتبر","../login.html");
	
	$oldpass = trim($_POST["oldpass"]);
	$newpass = trim($_POST["newpass"]);
	$newpass2 = trim($_POST["newpass2"]);
	
	if((strlen($oldpass) < 10) ||(strlen($oldpass) > 50) || (strlen($newpass) < 10)|| (strlen($newpass) > 50) || (strlen($newpass2) < 10)|| (strlen($newpass2) > 50))
	{
		MBox_Redirect_die("رمز عبور باید حداقل 10 و حداکثر 50 حرف باشد","../views/users/changepass.php");
	}
	if($newpass != $newpass2)
	{
		MBox_Redirect_die("رمز عبور و تکرار آن برابر نیست","../views/users/changepass.php");
	}
	
	$pass = Select("select * from Users where natCode =".$_SESSION["username"]);
	if($pass === null || count($pass) == 0)
		MBox_Redirect_Die("اطلاعاتی یافت نشد","../../logout.php");
	else 
		$pass = $pass[0]["password"];
	
	if($pass != $oldpass)
	{
		MBox_Redirect_die("رمز عبور فعلی صحیح نیست","../views/users/changepass.php");
	}
	else
	{
		
		$res = SqlCommand("update users set password = N'".$newpass."'"."where natcode = '".$_SESSION["username"]."'");
		if($res)
		{
			MBox_Redirect_die("رمز عبور با موفقیت تغییر یافت","../views/users/changepass.php");
		}
		else
		{
			MBox_Redirect_die("رمز عبور تغییر نیافت.مجددا تلاش بفرمایید","../views/users/changepass.php");
		}
		
	}
	
}
//-----------editProfile---------------------------------------------------------------------------------------------------------------------------
else if(array_key_exists("editProfile_user",$_POST))
{
	if(KeyExists($_POST,array("email","tel","address","id")) == false)
		MBox_Redirect_die("دسترسی نامعتبر","../views/users/editProfile.php");
	
	$email = trim($_POST["email"]);
	$tel = trim($_POST["tel"]);
	$address = trim($_POST["address"]);
	$id = trim($_POST["id"]);
	if((strlen($email) > 100)||(strlen($tel) > 15)||(strlen($address) > 500)||($id < 0)||(strlen($id) == 0) || (strlen($tel) != 0 && ctype_digit($tel) == 0) 
		||(strlen($email) != 0 && filter_var($email, FILTER_VALIDATE_EMAIL) == false)
	)
		MBox_Redirect_die("ورودی نامعتبر","../views/users/editProfile.php");
	
	if(strlen($email) == 0)
		$email = "NULL";
	else
		$email = "'".$email."'";
	
	if(strlen($address) == 0)
		$address = "NULL";
	else
		$address = "N'".$address."'";
	
	if(strlen($tel) == 0)
		$tel = "NULL";
	else
		$tel = "'".$tel."'";
	
	$q = "update users set email = ".$email.", tel = ".$tel.", address = ".$address." where id = ".$id;
	if(SqlCommand($q))
	{
		MBox_Redirect_die("اطلاعات با موفقیت ویرایش شد","../views/users/profile.php");
	}
	else
	{
		MBox_Redirect_die("اطلاعات ویرایش نشد.مجددا تلاش کنید","../views/users/editProfile.php");
	}
}
//-----------employees---------------------------------------------------------------------------------------------------------------------------

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 2)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");
//-----------AddNewPerson---------------------------------------------------------------------------------------------------------------------------
if(array_key_exists("addNewPerson_btn",$_POST))
{
	if(KeyExists($_POST,array("email","tel","address","fname","lname","natcode","fnat","mnat","sadere","isalive",
	"jensiat","shsh","bdate","ddate","pass")) == false)
	MBox_Redirect_die("دسترسی نامعتبر","../views/employees/AddNewPerson.php");
	
	$email = trim($_POST["email"]);
	$tel = trim($_POST["tel"]);
	$address = trim($_POST["address"]);
	$fname = trim($_POST["fname"]);
	$lname = trim($_POST["lname"]);
	$natCode = trim($_POST["natcode"]);
	$fnat = trim($_POST["fnat"]);
	$mnat = trim($_POST["mnat"]);
	$sadere = trim($_POST["sadere"]);
	$isalive = trim($_POST["isalive"]);
	$jensiat = trim($_POST["jensiat"]);
	$shsh = trim($_POST["shsh"]);
	$bdate = trim($_POST["bdate"]);
	$ddate = trim($_POST["ddate"]);
	$password = trim($_POST["pass"]);
	$pic = "";
	
	if(
	(strlen($fname) == 0) || (strlen($fname) > 50) ||
	(strlen($lname) == 0) || (strlen($lname) > 50) ||
	(strlen($natCode) != 10) || (ctype_digit($natCode) == false) ||
	(strlen($fnat) != 10 && strlen($fnat) != 0) || (strlen($fnat) != 0 && ctype_digit($fnat) == false) ||
	(strlen($mnat) != 10 && strlen($mnat) != 0) || (strlen($mnat) != 0 && ctype_digit($mnat) == false) ||
	(strlen($sadere) > 50) || 	(strlen($sadere) == 0) ||
	($isalive != 0 && $isalive != 1) || (strlen($isalive) != 1) ||
	($jensiat != 0 && $jensiat != 1) || (strlen($jensiat) != 1) ||
	(strlen($shsh) == 0) || (strlen($shsh) > 10) || (ctype_digit($shsh) == false) ||
	(strlen($bdate) != 10) || (preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$bdate)== false) ||
	(strlen($ddate) != 10 && strlen($ddate) != 0) || ($ddate != 0 && (preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$ddate)== false)) ||
	(strlen($password) < 10)||(strlen($password) > 50) ||
	(strlen($email) > 100)|| (strlen($email) != 0 && filter_var($email, FILTER_VALIDATE_EMAIL) == false) ||
	(strlen($tel) > 15)|| (strlen($tel) != 0 && ctype_digit($tel) == false) ||
	(strlen($address) > 500)
	)
		{
			MBox_Redirect_die("خطا در داده های ورودی","../views/employees/AddNewPerson.php");
		}
	
	
	if(strlen($ddate) == 0)
		$ddate = "NULL";
	else
		$ddate = "'" . $ddate ."'";
	
	if(strlen($email) == 0)
		$email = "NULL";
	else
		$email = "'" . $email ."'";
	
	if(strlen($address) == 0)
		$address = "NULL";
	else
		$address = "N'" . $address ."'";
	
	if(strlen($tel) == 0)
		$tel = "NULL";
	else
		$tel = "'" . $tel ."'";
	
	$fatherid = "NULL";
	if(strlen($fnat) != 0)
	{
		$pedar = Select("select id,Jensiat from users where natCode = ".$fnat);
		if((count($pedar) == 0) ||  ($pedar[0]["Jensiat"] =="0"))
			MBox_Redirect_die("کدملی پدر اشتباه است","../views/employees/AddNewPerson.php");
		$fatherid = $pedar[0]["id"];
	}
	$motherid = "NULL";
	if(strlen($mnat) != 0)
	{
		$madar = Select("select id,Jensiat from users where natCode = ".$mnat);
		if((count($madar) == 0) ||  ($madar[0]["Jensiat"] =="1"))
			MBox_Redirect_die("کدملی مادر اشتباه است","../views/employees/AddNewPerson.php");
		$motherid = $madar[0]["id"];
	}
		
	if ($_FILES["uppic"]["size"] != 0) 
	{
		$res = UploadFile("uppic",500000,array("jpg","png","jpeg","tiff","bmp"));
		if($res[0] == 0)
		{
			MBox_Redirect_die($res[1],"../views/employees/AddNewPerson.php");
		}
		else
		{
			if(strlen($pic) != 0)
			{
				$file = "../images/site/".$pic;
				if (file_exists($file)) 
				{
					unlink($file);
				}
			}
			$pic = $res[2];
		}
	}
	if(strlen($pic) == 0)
			$pic = "NULL";
		else
			$pic = "'".$pic."'";
	if(Select("select count(*) as cnt from users where natCode=".$natCode)[0]["cnt"] > 0)
		MBox_Redirect_die("خطا : شخصی با کد ملی وارد شده وجود دارد","../views/employees/addNewPerson.php");
	
	$q = "insert into users (id,fname,lname,natCode,fatherid,motherid,isAlive,password,BirthDate,DeathDate,Sadereh,picture,Roleid,Jensiat,shomareShenasname,
	Employeeid,Address,tel,email)
		values
	(NULL,N'".$fname."',N'".$lname."','".$natCode."',".$fatherid.",".$motherid.",".$isalive.",'".$password."',N'".$bdate."',".$ddate.",N'"
	.$sadere."',".$pic.",1,".$jensiat.",N'".$shsh."',".$_SESSION["userid"].",".$address.",".$tel.",".$email.")";
	if(SqlCommand($q))
	{
		MBox_Redirect_die("اطلاعات با موفقیت ثبت شد","../views/employees/addNewPerson.php");
	}
	else
	{
		MBox_Redirect_die("اطلاعات ثبت نشد.مجددا تلاش کنید","../views/employees/addNewPerson.php");
	}
	
}
//-----------AddNewMarry---------------------------------------------------------------------------------------------------------------------------
else if(array_key_exists("addNewMarryInfo_btn",$_POST))
{
	ini_set('max_execution_time', 300);
	
	if(KeyExists($_POST,array("mannat","womannat","marrydate")) == false)
			MBox_Redirect_die("دسترسی نامعتبر","../views/employees/addNewMarryInfo.php");
		
	$mnat = trim($_POST["mannat"]);
	$wnat = trim($_POST["womannat"]);
	$mdate = trim($_POST["marrydate"]);
	
	if((strlen($wnat) != 0 && strlen($wnat) != 10) || (strlen($wnat) != 0 && ctype_digit($wnat) == false) ||
	(strlen($mnat) != 0 && strlen($mnat) != 10) || (strlen($mnat) != 0 && ctype_digit($mnat) == false) ||
	(preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$mdate)== false)
	)
	{
		MBox_Redirect_die("ورودی اشتباه است","../views/employees/addNewMarryInfo.php");
	}
	
	
	$url = "../views/employees/addNewMarryInfo.php";
	$r = Mahram($mnat,$wnat,0,$url);
	$mid = $r[0];
	$wid = $r[1];
	
	$q = "insert into marryinfo (id,manpersonid,womanpersonid,marrydate,talaghdate,employeeid) values(NULL,".$mid.",".$wid.",'".$mdate."',NULL,".$_SESSION["userid"].")";
	if(SqlCommand($q))
	{
		MBox_Redirect_die("اطلاعات با موفقیت ثبت شد","../views/employees/addNewMarryInfo.php");
	}
	else
	{
		MBox_Redirect_die("اطلاعات ثبت نشد.مجددا تلاش کنید","../views/employees/addNewMarryInfo.php");
	}

}
//-----------EditMarry---------------------------------------------------------------------------------------------------------------------------
else if(array_key_exists("editMarryInfo_employee",$_POST))
{
	ini_set('max_execution_time', 300);
	
	if(KeyExists($_POST,array("mannat","womannat","marrydate","talaghdate","id")) == false)
		MBox_Redirect_die("دسترسی نامعتبر","../views/employees/editMarry.php");
	
	$id = trim($_POST["id"]);
	$mnat = trim($_POST["mannat"]);
	$wnat = trim($_POST["womannat"]);
	$mdate = trim($_POST["marrydate"]);
	$talaghdate = trim($_POST["talaghdate"]);
	$msearch = trim((KeyExists($_POST,array("msearch")) ?$_POST["msearch"]:""));
	
	if((strlen($wnat) != 0 && strlen($wnat) != 10) || (strlen($wnat) != 0 && ctype_digit($wnat) == false) ||
	(strlen($mnat) != 0 && strlen($mnat) != 10)|| (strlen($mnat) != 0 && ctype_digit($mnat) == false) ||
	(strlen($id) == 0) || ($id < 0) ||
	(preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$mdate)== false) ||
	($talaghdate != 0 && (preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$talaghdate)== false))
	)
	{
		MBox_Redirect_die("ورودی اشتباه است",'../views/employees/editMarry.php?Marryid='.$id.'&msearch='.$msearch);
	}
	if(strlen($talaghdate) == 0)
	{
		$talaghdate = "NULL";
	}
	else
	{
		$talaghdate = "'".$talaghdate."'";
	}
	$url = '../views/employees/editMarry.php?Marryid='.$id.'&msearch='.$msearch;
	$r = Mahram($mnat,$wnat,1,$url);
	$mid = $r[0];
	$wid = $r[1];
	$q = "update marryinfo set manpersonid=".$mid." ,womanpersonid=".$wid." ,marrydate='".$mdate."',talaghdate=".$talaghdate."  where id=".$id;
	if(SqlCommand($q))
	{
		MBox_Redirect_die("اطلاعات با موفقیت ویرایش شد","../views/employees/showAllMarries.php?msearch=".$msearch);
	}
	else
	{
		MBox_Redirect_die("اطلاعات ویرایش نشد.مجددا تلاش کنید","../views/employees/editMarry.php?Marryid=".$id."&msearch=".$msearch);
	}

}
//-----------EditPerson---------------------------------------------------------------------------------------------------------------------------
else if(array_key_exists("editPerson_employee",$_POST))
{
	if(KeyExists($_POST,array("email","tel","address","id","fname","lname","natcode","fnat","mnat","sadere","isalive",
	"jensiat","shsh","bdate","ddate","pass","pic")) == false)
	MBox_Redirect_die("دسترسی نامعتبر","../views/employees/editPerson.php");
	
	$email = trim($_POST["email"]);
	$tel = trim($_POST["tel"]);
	$address = trim($_POST["address"]);
	$id = trim($_POST["id"]);
	$fname = trim($_POST["fname"]);
	$lname = trim($_POST["lname"]);
	$natCode = trim($_POST["natcode"]);
	$fnat = trim($_POST["fnat"]);
	$mnat = trim($_POST["mnat"]);
	$sadere = trim($_POST["sadere"]);
	$isalive = trim($_POST["isalive"]);
	$jensiat = trim($_POST["jensiat"]);
	$shsh = trim($_POST["shsh"]);
	$bdate = trim($_POST["bdate"]);
	$ddate = trim($_POST["ddate"]);
	$password = trim($_POST["pass"]);
	$search = trim($_POST["search"]);
	$pic = trim($_POST["pic"]);
	
	$search = trim((KeyExists($_POST,array("search")) ?$_POST["search"]:""));
	
	
	if(
	(strlen($id) == 0 ) || ($id < 1) ||
	(strlen($fname) == 0) || (strlen($fname) > 50) ||
	(strlen($lname) == 0) || (strlen($lname) > 50) ||
	(strlen($natCode) != 10) || (ctype_digit($natCode) == false) ||
	(strlen($fnat) != 10 && strlen($fnat) != 0) || (strlen($fnat) == 10 && ctype_digit($fnat) == false) ||
	(strlen($mnat) != 10 && strlen($mnat) != 0) || (strlen($mnat) == 10 && ctype_digit($mnat) == false) ||
	(strlen($sadere) > 50) || 	(strlen($sadere) == 0) ||
	($isalive != 0 && $isalive != 1) || (strlen($isalive) != 1) ||
	($jensiat != 0 && $jensiat != 1) || (strlen($jensiat) != 1) ||
	(strlen($shsh) == 0) || (strlen($shsh) > 10) || (ctype_digit($shsh) == false) ||
	(strlen($bdate) != 10) || (preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$bdate)== false) ||
	(strlen($ddate) != 10 && strlen($ddate) != 0) || ($ddate != 0 && (preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$ddate)== false)) ||
	(strlen($password) < 10)||(strlen($password) > 50) ||
	(strlen($email) > 100)|| (strlen($email) != 0 && filter_var($email, FILTER_VALIDATE_EMAIL) == false) ||
	(strlen($tel) > 15)|| (strlen($tel) != 0 && ctype_digit($tel) == false) ||
	(strlen($address) > 500)
	)
		{
			MBox_Redirect_die("خطا در داده های ورودی","../views/employees/editPerson.php?search=".$search."&Userid=".$id);
		}
	
	$fatherid = "NULL";
	if(strlen($fnat) != 0)
	{
		$pedar = Select("select id,Jensiat from users where natCode = ".$fnat);
		if((count($pedar) == 0) ||  ($pedar[0]["Jensiat"] =="0"))
			MBox_Redirect_die("کدملی پدر اشتباه است","../views/employees/AddNewPerson.php");
		$fatherid = $pedar[0]["id"];
	}
	$motherid = "NULL";
	if(strlen($mnat) != 0)
	{
		$madar = Select("select id,Jensiat from users where natCode = ".$mnat);
		if((count($madar) == 0) ||  ($madar[0]["Jensiat"] =="1"))
			MBox_Redirect_die("کدملی مادر اشتباه است","../views/employees/AddNewPerson.php");
		$motherid = $madar[0]["id"];
	}
	
	if(strlen($ddate) == 0)
		$ddate = "NULL";
	else
		$ddate = "'" . $ddate ."'";
	
	if(strlen($email) == 0)
		$email = "NULL";
	else
		$email = "'" . $email ."'";
	
	if(strlen($address) == 0)
		$address = "NULL";
	else
		$address = "N'" . $address ."'";
	
	if(strlen($tel) == 0)
		$tel = "NULL";
	else
		$tel = "'" . $tel ."'";
	
	if ($_FILES["uppic"]["size"] != 0) 
	{
		$res = UploadFile("uppic",500000,array("jpg","png","jpeg","tiff","bmp"));
		if($res[0] == 0)
		{
			MBox_Redirect_die($res[1],"../views/employees/editPerson.php?search=".$search."&Userid=".$id);
		}
		else
		{
			if(strlen($pic) != 0)
			{
				$file = "../images/site/".$pic;
				if (file_exists($file)) 
				{
					unlink($file);
				}
			}
			$pic = $res[2];
		}
	}
	if(strlen($pic) == 0)
			$pic = "NULL";
		else
			$pic = "'".$pic."'";
	
	$q = "update users set email = ".$email.", tel = ".$tel.", address = ".$address.",fname = N'".$fname."',lname=N'".$lname."' ,
	natCode ='".$natCode."' ,shomareShenasname= '".$shsh."',BirthDate= '".$bdate."',DeathDate= ".$ddate.",password=N'".$password."' 
	,motherid= ".$motherid.",fatherid= ".$fatherid.",Jensiat=".$jensiat." ,isAlive=".$isalive." ,Sadereh=N'".$sadere."' , picture=".$pic." where id = ".$id;
	if(SqlCommand($q))
	{
		MBox_Redirect_die("اطلاعات با موفقیت ویرایش شد","../views/employees/showAllPersons.php?search=".$search);
	}
	else
	{
		MBox_Redirect_die("اطلاعات ویرایش نشد.مجددا تلاش کنید","../views/employees/editPerson.php?search=".$search."&Userid=".$id);
	}
}


if(array_key_exists( "deleteUserid",$_GET))
{
	if(KeyExists($_GET,array("deleteUserid")) == false)
		MBox_Redirect_die("دسترسی نامعتبر","../views/employees/showAllPersons.php");
	$userid = trim($_GET["deleteUserid"]);
	if((strlen($userid) == 0) || ($userid < 1))
		MBox_Redirect_die("مقادیر نامعتبر","../views/employees/showAllPersons.php");
	
	$search = trim((KeyExists($_GET,array("search")) ?$_GET["search"]:""));
	$selsearch = trim(array_key_exists("selectsearch",$_GET)?$_GET["selectsearch"]:"");
	
	$picadd = Select("select picture from users where id=".$userid);
	$pic ="";
	if(count($picadd) > 0)
		$pic = $picadd[0]["picture"];
	
	if(SqlCommand("delete from users where id =".$userid))
	{
		if(strlen($pic) != 0)
		{
			$file = "../images/site/".$pic;
			if(file_exists($file)) 
			{
				unlink($file);
			}
		}
		MBox_Redirect_die("اطلاعات با موفقیت حذف شد","../views/employees/showAllPersons.php?search=".$search."&searchselect=".$selsearch);
	}
	else
	{
		MBox_Redirect_die("اطلاعات حذف نشد.مجددا تلاش کنید","../views/employees/showAllPersons.php?search=".$search."&searchselect=".$selsearch);
	}
}
else if(array_key_exists("deleteMarryid",$_GET))
{
	if(KeyExists($_GET,array("deleteMarryid")) == false)
		MBox_Redirect_die("دسترسی نامعتبر","../views/employees/showAllMarries.php");
	$marryid = trim($_GET["deleteMarryid"]);
	if((strlen($marryid) == 0) || ($marryid < 1))
		MBox_Redirect_die("مقادیر نامعتبر","../views/employees/showAllMarries.php");
	
	$msearch = trim((KeyExists($_GET,array("msearch")) ?$_GET["msearch"]:""));
	if(SqlCommand("delete from marryinfo where id =".$marryid))
	{
		MBox_Redirect_die("اطلاعات با موفقیت حذف شد","../views/employees/showAllMarries.php?msearch=".$msearch);
	}
	else
	{
		MBox_Redirect_die("اطلاعات حذف نشد.مجددا تلاش کنید","../views/employees/showAllMarries.php?msearch=".$msearch);
	}
}

function Mahram($mnat,$wnat,$hamsarCount,$url)
{
	//----------- check jensiat 
	$man = Select("select id,Jensiat from users where natCode =".$mnat);
	if((count($man) == 0) || ($man[0]["Jensiat"] != 1))
		MBox_Redirect_die("خطا : کدملی وارد شده برای مرد اشتباه است است",$url);
	else 
		$mid = $man[0]["id"];
	

	$woman = Select("select id,Jensiat from users where natCode =".$wnat);
	if((count($woman) == 0) || ($woman[0]["Jensiat"] != 0))
		MBox_Redirect_die("خطا : کدملی وارد شده برای زن اشتباه است است",$url);
	else 
		$wid = $woman[0]["id"];
	//----------- check tedad hamsar baraye zan
	$marrycount = Select("select count(*) as cnt from users where isAlive = 1 and id in (select manpersonid from marryinfo where talaghdate is null and womanpersonid = ".$wid.")")[0];
	if($marrycount["cnt"] > $hamsarCount)
		MBox_Redirect_die("خطا : زن در هر لحظه فقط میتواند 1 همسر داشته باشد",$url);
	
	//------------------------------------------------------------------- nasabi
	//-----------madaran
	$madaran = Select("call getParentsID(".$mid.",0)");
	for($i=0;$i < count($madaran);$i++)
		if($madaran[$i]["id"] == $wid)
			MBox_Redirect_die("مادر، مادربزرگ پدری و مادری هر چه بالاتر روند جزو محارم محسوب میشوند",$url);
	//-----------farzandan
	$farzandan = Select("call getChildID(".$mid.",0)");
	for($i=0;$i < count($farzandan);$i++)
		if($farzandan[$i]["id"] == $wid)
			MBox_Redirect_die("دختر خود انسان و دخترِ پسر یا دخترِ دختر انسان (نوه‌ها و نتیجه‌ها هر چه پایین‌تر روند) جزو محارم محسوب میشوند",$url);
	//-----------khaharan
	$khaharan = Select("select id from users where (motherid in (select motherid from users where id = ".$mid." 
	union ALL select fatherid from users where id = ".$mid.") or fatherid in (select motherid from users where id = ".$mid."
	union ALL select fatherid from users where id = ".$mid.")) and Jensiat = 0");
	for($i=0;$i < count($khaharan);$i++)
		if($khaharan[$i]["id"] == $wid)
			MBox_Redirect_die("خواهر یعنی دختری که مادر او یا پدر او یا هر دوی آنان با مرد مزبور یکی باشد جزو محارم محسوب میشوند",$url);
	//-----------farzandane khahar
	for($i=0;$i < count($khaharan);$i++)
	{
		$farzandane_khahar = Select("call getChildID(".$khaharan[$i]["id"].",0)");
		for($j=0;$j < count($farzandane_khahar);$j++)
		if($farzandane_khahar[$j]["id"] == $wid)
			MBox_Redirect_die("اولاد و نوه‌ها و نتیجه‌های خواهر هر چه پایین‌تر روند جزو محارم محسوب میشوند",$url);
	}
	//-----------farzandane baradar
	$baradaran = Select("select id from users where (motherid in (select motherid from users where id = ".$mid." 
	union ALL select fatherid from users where id = ".$mid.") or fatherid in (select motherid from users where id = ".$mid." 
	union ALL select fatherid from users where id = ".$mid.")) and Jensiat = 1");
	for($i=0;$i < count($baradaran);$i++)
	{
		$farzandane_baradar = Select("call getChildID(".$baradaran[$i]["id"].",0)");
		for($j=0;$j < count($farzandane_baradar);$j++)
		if($farzandane_baradar[$j]["id"] == $wid)
			MBox_Redirect_die("اولاد و نوه‌ها و نتیجه‌های برادر هر چه پایین‌تر روند جزو محارم محسوب میشوند",$url);
	}
	//-----------ammeha
	$ammeha = Select("call getAmme_AmooID(".$mid.",0)");
	for($i=0;$i < count($ammeha);$i++)
		if($ammeha[$i]["id"] == $wid)
			MBox_Redirect_die("عمّه خود شخص و عمّه پدر و مادر و نیز عمّه مادر بزرگ‌ها و پدر بزرگ‌ها جزو محارم محسوب میشوند",$url);
	//-----------khaleha
	$khaleha = Select("call getDaei_KhaleID(".$mid.",0)");
	for($i=0;$i < count($khaleha);$i++)
		if($khaleha[$i]["id"] == $wid)
			MBox_Redirect_die("خاله خود شخص و خاله پدر و مادر و نیز خاله مادر بزرگ‌ها و پدر بزرگ‌ها جزو محارم محسوب میشوند",$url);
	//---------------------------------------------------------------------------- sababi(mard)
	//-----------madar_zanha
	$zanha = Select("select womanpersonid as id from marryinfo where manpersonid = ".$mid);
	for($i=0;$i < count($zanha);$i++)
	{
		$madar_zanha = Select("call getParentsID(".$zanha[$i]["id"].",0)");
		for($j=0;$j < count($madar_zanha);$j++)
		if($madar_zanha[$j]["id"] == $wid)
			MBox_Redirect_die(" به محض جاری شدن صیغه عقد ازدواج دائم یا موقت، مادر و مادربزرگ‌های عروس هر چه بالا‌تر روند، نسبت به داماد مَحرم ابدی می‌شوند. یعنی حتی بعد از مرگ یا طلاق عروس هم مَحرم باقی می‌مانند.","../views/employees/addNewMarryInfo.php");
	}
	//-----------nadokhtarha
	for($i=0;$i < count($zanha);$i++)
	{
		$nadokhtarha = Select("call getChildID(".$zanha[$i]["id"].",0)");
		for($j=0;$j < count($nadokhtarha);$j++)
		if($nadokhtarha[$j]["id"] == $wid)
			MBox_Redirect_die("دختر زن ( نادختري) و نوه هاي او تا آخر جزو محارم محسوب میشوند",$url);
	}
	//-----------zan_haye_pedar
	$zan_haye_pedar = Select("select womanpersonid as id from marryinfo where manpersonid in (select fatherid from users where id = ".$mid.")");
	for($i=0;$i < count($zan_haye_pedar);$i++)
		if($zan_haye_pedar[$i]["id"] == $wid)
			MBox_Redirect_die("زن پدر( نامادري)  جزو محارم محسوب میشوند",$url);
	//-----------navade haye pesarie zan
	// for($i=0;$i < count($zanha);$i++)
	// {
		// $navadehaye_dokhtarie_pesarha = Select("call getNavadeID(".$zanha[$i]["id"].",0,1)");
		// for($j=0;$j < count($navadehaye_dokhtarie_pesarha);$j++)
			// if($navadehaye_dokhtarie_pesarha[$j]["id"] == $wid)
				// MBox_Redirect_die("نواده‌های پسری زن (تا آخر) محرم هستند",$url);
	// }
	//---------------------------------------------------------------------------- sababi(zan)
	//-----------pedar_shohar_ha
	$shoharha = Select("select manpersonid as id from marryinfo where womanpersonid = ".$wid);
	for($i=0;$i < count($shoharha);$i++)
	{
		$pedar_shohar_ha = Select("call getParentsID(".$shoharha[$i]["id"].",1)");
		for($j=0;$j < count($pedar_shohar_ha);$j++)
		if($pedar_shohar_ha[$j]["id"] == $mid)
			MBox_Redirect_die(" به محض جاری شدن صیغه عقد ازدواج دائم یا موقت، پدر و پدر بزرگ های داماد هر چه بالا‌تر روند، نسبت به عروس مَحرم ابدی می‌شوند. یعنی حت
		ی بعد از مرگ یا طلاق هم مَحرم باقی می‌مانند.",$url);
	}
	//-----------napesarha
	for($i=0;$i < count($shoharha);$i++)
	{
		$napesarha = Select("call getChildID(".$shoharha[$i]["id"].",1)");
		for($j=0;$j < count($napesarha);$j++)
		if($napesarha[$j]["id"] == $mid)
			MBox_Redirect_die("پسرشوهر (ناپسري ) و نوه هاي او تا آخر جزو محارم محسوب میشوند",$url);
	}
	//-----------shohar_haye_madar
	$shohar_haye_madar = Select("select manpersonid as id from marryinfo where womanpersonid in (select motherid from users where id = ".$wid.")");
	for($i=0;$i < count($shohar_haye_madar);$i++)
		if($shohar_haye_madar[$i]["id"] == $mid)
			MBox_Redirect_die("شوهر مادر (ناپدري)  جزو محارم محسوب میشوند",$url);
	
	//-----------navade haye dokhtarie shohar
	// for($i=0;$i < count($shoharha);$i++)
	// {
		// $navadehaye_pesarie_dokhtarha = Select("call getNavadeID(".$shoharha[$i]["id"].",1,0)");
		// for($j=0;$j < count($navadehaye_pesarie_dokhtarha);$j++)
			// if($navadehaye_pesarie_dokhtarha[$j]["id"] == $mid)
				// MBox_Redirect_die("نواده هاي دختري شوهر (تا آخر) محرم هستند",$url);
	// }
	return array($mid,$wid);
}
//-----------admins---------------------------------------------------------------------------------------------------------------------------
if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] != 3)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");
//-----------setAccessLevel---------------------------------------------------------------------------------------------------------------------------
if(array_key_exists("setAccessLevel_admin",$_POST))
{
	// $search = trim((KeyExists($_POST,array("search")) ?$_POST["search"]:""));
	// $searchselect = trim((KeyExists($_POST,array("searchselect")) ?$_POST["searchselect"]:""));
	
	if(KeyExists($_POST,array("natcode","role")) == false)
	MBox_Redirect_die("دسترسی نامعتبر","../views/admins/setAccessLevel.php?search=".$search."&searchselect=".$searchselect);
	
	$natcode = trim($_POST["natcode"]);
	$roleid = trim($_POST["role"]);
	

	
	if((strlen($natcode) != 10) || (ctype_digit($natcode) == false) || (strlen($roleid) == 0) || (ctype_digit($roleid) == false))
		MBox_Redirect_die("ورودی نامعتبر","../views/admins/setAccessLevel.php"
	.(KeyExists($_POST,array("search")) ?"?search=".$_POST["search"].((KeyExists($_POST,array("searchselect")) ?"&searchselect=".$_POST["searchselect"]:"")):""));
	
	$rolecount = Select("select count(*) as cnt from systemroles where id = ".$roleid)[0];
	if($rolecount["cnt"] == 0) 
		MBox_Redirect_die("نقش مورد نظر در سیستم وجود ندارد","../views/admins/setAccessLevel.php"
	.(KeyExists($_POST,array("search")) ?"?search=".$_POST["search"].((KeyExists($_POST,array("searchselect")) ?"&searchselect=".$_POST["searchselect"]:"")):""));
	
	$personcount = Select("select count(*) as cnt from users where natcode = ".$natcode)[0];
	if($personcount["cnt"] == 0) 
		MBox_Redirect_die("فرد مورد نظر در سیستم وجود ندارد","../views/admins/setAccessLevel.php"
	.(KeyExists($_POST,array("search")) ?"?search=".$_POST["search"].((KeyExists($_POST,array("searchselect")) ?"&searchselect=".$_POST["searchselect"]:"")):""));
	
	$q = "update users set roleid = ".$roleid." where natcode='".$natcode."'";
	if(SqlCommand($q))
	{
		MBox_Redirect_die("اطلاعات با موفقیت ویرایش شد","../views/admins/setAccessLevel.php"
		.(KeyExists($_POST,array("search")) ?"?search=".$_POST["search"].((KeyExists($_POST,array("searchselect")) ?"&searchselect=".$_POST["searchselect"]:"")):""));
	}
	else
	{
		MBox_Redirect_die("اطلاعات ویرایش نشد.مجددا تلاش کنید","../views/admins/setAccessLevel.php?"
		.(KeyExists($_POST,array("search")) ?"?search=".$_POST["search"].((KeyExists($_POST,array("searchselect")) ?"&searchselect=".$_POST["searchselect"]:"")):"").
		"Usernat=".$natcode."&role=".$roleid);
	}

	
	
}



?>