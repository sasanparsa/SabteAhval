<?php

function KeyExists($var,$arr)
{
	for($i=0;$i<count($arr);$i++)
	{
		if(array_key_exists( $arr[$i],$var) == false)
			return false;
	}
	return true;
}

function SearchInAssArray($arr,$field,$value)
{
	for($i = 0 ;$i < count($arr);$i++)
		if($arr[$i][$field] == $value)
			return true;
	return false;
}

function sortBy($field, &$array, $direction = 'asc')
{
    usort($array, create_function(  '$a, $b', '
                                     $a = $a["' . $field . '"];
                                     $b = $b["' . $field . '"];
                                     if ($a == $b) {
                                         return 0;
                                     }

                                     return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;'));

    return true;
}

function GetDefaultPicturePath($sel)
{
    if($sel == 0)
		return "def_woman.png";
	else if($sel == 1)
		return "def_man.png";
	else if($sel == 2)
		return "def.png";
}

function MBox($msg)
{
	echo "<script type='text/javascript'>alert('".$msg."');</script>";
}

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    //exit();
}

function Mbox_Redirect($msg,$url)
{
echo '<script> alert("'.$msg.'"); window.location.href="'.$url.'"; </script>';
//echo '<script> alert("سیشیشیش \n یشیشسیش"); </script>';
	
}

function MBox_Redirect_die($msg,$url)
{
	MBox_Redirect($msg,$url);
		die();
	
}
function GenerateRandomNumber()
{
	$res = date('YmdHis');
	for($i=0;$i<15;$i++)
		$res .= rand(0,10);
	return $res;
}
function UploadFile($name,$fileSize,$formats)
{
	$target_dir = "../images/site/";
	$target_file = $target_dir . basename($_FILES[$name]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$ax_name = GenerateRandomNumber().".". $imageFileType;
	$target_file = $target_dir .$ax_name;
	$msg = "";
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"]))
	{
		$check = getimagesize($_FILES[$name]["tmp_name"]);
		  if($check === false) {
			$msg .= "فایل ارسال شده یک عکس نیست";
			$msg .= "\\n";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) 
	{
		$msg .= "فایل ارسال شده موجود است";
		$msg .= "\\n";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES[$name]["size"] > $fileSize) 
	{
		$msg .= "حجم فایل ارسال شده زیاد است.";
		$msg .= " حداکثر میزان حجم" .($fileSize/1000)." کیلو بایت است";
		$msg .= "\\n";
		$uploadOk = 0;
	}
	// Allow certain file formats
	$fm = 0;
	for($i=0;$i < count($formats);$i++)
		if($imageFileType == $formats[$i])
		{
			$fm = 1;
			break;
		}
	if($fm == 0)
	{
		$uploadOk = 0;
		$msg .= "فرمت فایل ارسالی اشتباه است";
		$msg .= "\\n";
	}
		
	if ($uploadOk == 1) 
	{
		if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file))
		{
			$uploadOk = 1;
		} 
		else 
		{
			$uploadOk = 0;
			$msg .= "در هنگام ذخیره سازی خطایی رخ داد.مجددا تلاش کنید";
			$msg .= "\\n";
		}

	}
		return array($uploadOk,$msg,$ax_name);
}

?>