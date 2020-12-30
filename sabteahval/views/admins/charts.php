	<?php
session_start();
require "../../controllers/Utilities.php";
require "../../controllers/Database.php";

if((array_key_exists("roleid",$_SESSION) == false) || $_SESSION["roleid"] < 3)
	MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");

$date1 = trim(array_key_exists("date1",$_GET)?$_GET["date1"]:"");
$date2 = trim(array_key_exists("date2",$_GET)?$_GET["date2"]:"");
if(strlen($date1) == 0)
	$date1 = "1300";
else if(preg_match("/^[0-9]{4}$/",$date1)== false )
	MBox_Redirect_Die("ورودی اشتباه","charts.php");
if(strlen($date2) == 0)
	$date2 = "1400";
else if(preg_match("/^[0-9]{4}$/",$date2)== false )
	MBox_Redirect_Die("ورودی اشتباه","charts.php");

if($date1 > $date2)
	MBox_Redirect_Die("خطا : تاریخ دوم کوچکتر است","charts.php");
$page = "نمودار ها";
//--------motevaledin-----------------------------------------------------------------------------------------
$res = Select("SELECT substring(birthdate,1,position('/' in birthdate)-1) as year,count(*) as cnt
				from users 
				where substring(birthdate,1,position('/' in birthdate)-1) between '".$date1."' and '".$date2."'
				group by substring(birthdate,1,position('/' in birthdate)-1)"
 );
 for($i=$date1;$i <= $date2;$i++)
 {
	 if(SearchInAssArray($res,"year",$i) == false)
	 {
		 $res += array( "".count($res).""=> array("year" => "".$i."", "cnt" => "0"));
	 }
 }
 sortBy('year', $res, 'asc'); 

$jscript = "
$(function(){ 
	$('.w1,.w2,.w3').each(function(){
		$(this).css('width','1300');
});});
            chtype = 'line';
            var chartdata = [];";

            for($i = 0 ; $i < count($res); $i++)
			{
            $jscript .= "chartdata.push({ label: '".$res[$i]["year"]."', y: ".$res[$i]["cnt"]." });";
			}
   $jscript .= " window.onload = function () {
                var chart = new CanvasJS.Chart('birth', {
                    theme : 'light2',
                    title:{text: 'متولدین'},
                    axisY:{title: 'تعداد'},
                    axisX:{title: 'سال',interval: 1},
                    data: [{type: chtype,dataPoints: chartdata}]
                });
                chart.render();
   
   

";
//--------fot shode ha-----------------------------------------------------------------------------------------
$res = Select("SELECT substring(deathdate,1,position('/' in deathdate)-1) as year,count(*) as cnt
				from users 
				where substring(deathdate,1,position('/' in deathdate)-1) between '".$date1."' and '".$date2."'
				group by substring(deathdate,1,position('/' in deathdate)-1)"
 );
 for($i=$date1;$i <= $date2;$i++)
 {
	 if(SearchInAssArray($res,"year",$i) == false)
	 {
		 $res += array( "".count($res).""=> array("year" => "".$i."", "cnt" => "0"));
	 }
 }
 sortBy('year', $res, 'asc'); 

$jscript .= "
             chartdata = [];";

            for($i = 0 ; $i < count($res); $i++)
			{
            $jscript .= "chartdata.push({ label: '".$res[$i]["year"]."', y: ".$res[$i]["cnt"]." });";
			}
   $jscript .= "
                var chart = new CanvasJS.Chart('death', {
                    theme : 'light2',
                    title:{text: 'فوت شده ها'},
                    axisY:{title: 'تعداد'},
                    axisX:{title: 'سال',interval: 1},
                    data: [{type: chtype,dataPoints: chartdata}]
                });
                chart.render();
   

";
//--------ezdevaj-----------------------------------------------------------------------------------------
$res = Select("SELECT substring(marrydate,1,position('/' in marrydate)-1) as year,count(*) as cnt
				from marryinfo 
				where substring(marrydate,1,position('/' in marrydate)-1) between '".$date1."' and '".$date2."'
				group by substring(marrydate,1,position('/' in marrydate)-1)"
 );
 for($i=$date1;$i <= $date2;$i++)
 {
	 if(SearchInAssArray($res,"year",$i) == false)
	 {
		 $res += array( "".count($res).""=> array("year" => "".$i."", "cnt" => "0"));
	 }
 }
 sortBy('year', $res, 'asc'); 

$jscript .= "
             chartdata = [];";

            for($i = 0 ; $i < count($res); $i++)
			{
            $jscript .= "chartdata.push({ label: '".$res[$i]["year"]."', y: ".$res[$i]["cnt"]." });";
			}
   $jscript .= "
                var chart = new CanvasJS.Chart('marry', {
                    theme : 'light2',
                    title:{text: 'ازدواج ها'},
                    axisY:{title: 'تعداد'},
                    axisX:{title: 'سال',interval: 1},
                    data: [{type: chtype,dataPoints: chartdata}]
                });
                chart.render();
   

";
//--------talagh-----------------------------------------------------------------------------------------
$res = Select("SELECT substring(talaghdate,1,position('/' in talaghdate)-1) as year,count(*) as cnt
				from marryinfo 
				where substring(talaghdate,1,position('/' in talaghdate)-1) between '".$date1."' and '".$date2."'
				group by substring(talaghdate,1,position('/' in talaghdate)-1)"
 );
 for($i=$date1;$i <= $date2;$i++)
 {
	 if(SearchInAssArray($res,"year",$i) == false)
	 {
		 $res += array( "".count($res).""=> array("year" => "".$i."", "cnt" => "0"));
	 }
 }
 sortBy('year', $res, 'asc'); 

$jscript .= "
             chartdata = [];";

            for($i = 0 ; $i < count($res); $i++)
			{
            $jscript .= "chartdata.push({ label: '".$res[$i]["year"]."', y: ".$res[$i]["cnt"]." });";
			}
   $jscript .= "
                var chart = new CanvasJS.Chart('talagh', {
                    theme : 'light2',
                    title:{text: 'طلاق ها'},
                    axisY:{title: 'تعداد'},
                    axisX:{title: 'سال',interval: 1},
                    data: [{type: chtype,dataPoints: chartdata}]
                });
                chart.render();
   

";
//--------jamiat-----------------------------------------------------------------------------------------
$q = "    
	select year,
    (select count(*) from users where substring(birthdate,1,position('/' in birthdate)-1) <= tbl.year) -
    (select count(*) from users where substring(DeathDate,1,position('/' in DeathDate)-1) <= tbl.year) as jmt
    from(";
	
	for($i=$date1;$i<$date2;$i++)
		$q.="select ".$i." as year union ";
	$q.="select ".$date2." as year ";
	
$q .= ") as tbl
    order by year asc";

$res = Select($q);


$jscript .= "
             chartdata = [];";

            for($i = 0 ; $i < count($res); $i++)
			{
            $jscript .= "chartdata.push({ label: '".$res[$i]["year"]."', y: ".$res[$i]["jmt"]." });";
			}
   $jscript .= "
                var chart = new CanvasJS.Chart('jamiat', {
                    theme : 'light2',
                    title:{text: 'جمعیت'},
                    axisY:{title: 'تعداد'},
                    axisX:{title: 'سال',interval: 1},
                    data: [{type: chtype,dataPoints: chartdata}]
                });
                chart.render();
   }

";

$cnt = "";
//-------------------------------------------------------------------------------------------------

$cnt = $cnt. "<form method='get' action='charts.php'><div>
<style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}.lb{color:lightgreen}</style>";				
$cnt = $cnt .'<div class="cl"><label class="lb">از سال : </label> <input style="direction:ltr;" value="'.$date1.'" type="text" name="date1"/></div>';
$cnt = $cnt .'<div  class="cl"><label class="lb">تا سال : </label> <input style="direction:ltr;" value="'.$date2.'" type="text" name="date2"/></div>';
$cnt = $cnt .'<div style="margin-right:30px;margin-bottom:5px;"><button class="button" name="changepass_form_changepass_btn">دریافت اطلاعات</button></div></form>';
$cnt = $cnt.'</div><br>';


$cnt = $cnt. "<div><style> .cl{margin-right:30px;margin-bottom:5px;color:white;background-color:#123456;padding:3px;border-radius:2px;width:400px;}
				.lb{color:lightgreen} .chartcnt{border-radius:3px;border:5px solid black;}</style>";				
$cnt = $cnt .'<div id="birth" class ="chartcnt" style="height: 250px;direction:ltr"></div>
            <br />';
$cnt = $cnt .'<div id="death" class ="chartcnt" style="height: 250px;direction:ltr"></div>
            <br />';
$cnt = $cnt .'<div id="jamiat"class ="chartcnt" style="height: 250px;direction:ltr"></div>
            <br />';
$cnt = $cnt .'<div id="marry" class ="chartcnt" style="height: 250px;direction:ltr"></div>
            <br />';
$cnt = $cnt .'<div id="talagh"class ="chartcnt" style="height: 250px;direction:ltr"></div>
            <br />';

$cnt = $cnt.'</div>';
include "adminMasterPage.php"; 	
?>
