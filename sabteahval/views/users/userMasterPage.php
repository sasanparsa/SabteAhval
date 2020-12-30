<?php
	if(array_key_exists( "userid",$_SESSION) == false)
		MBox_Redirect_Die("دسترسی نامعتبر","../../login.html");
 ?>
<!DOCTYPE html>
<html>
	
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    	<meta charset="utf-8">
        <title>ثبت احوال </title>
		<?php  if(isset($csslink)) echo $csslink;    ?>
		<style>
		<?php  if(isset($style)) echo $style;    ?>
		</style>
        <link rel="stylesheet" href="../../css/markup.css">
        <link rel="stylesheet" href="../../css/flexslider.css">
        <link rel="stylesheet" href="../../css/elastislide.css">
        <link rel="stylesheet" href="../../css/jquery.jqzoom.css">
        <link rel="stylesheet" href="../../css/style.css">
		
		
        <script src="../../js/jquery-1.8.3.min.js"></script>
        <script src="../../js/jquery.jqzoom-core-pack.js"></script>
        <script src="../../js/jquery.flexslider-min.js"></script>
        <script src="../../js/modernizr.custom.17475.js"></script>
        <script src="../../js/jquery.elastislide.js"></script>
        <script src="../../js/tabs.js"></script>
		<script src="../../js/cycle.js" type="text/javascript"></script>
        <script src="../../js/main.js"></script>
		
		<link rel="stylesheet" href="../../css/sitecss.css">
		
		
    </head>
    <body>
    	    	<div id="fb-root"></div>
	
           
            <nav class="pivot grid" style="margin-top:30px">
                <ul class="nav">
                    <li class="nav-item"><a class="nav-item-link" href="profile.php"><div class="nav-item-home-icon"></div></a></li>
                    <li class="nav-item">
                       
                    <li class="nav-item"><a class="nav-item-link" href="profile.php">نمایش پروفایل</a></li>
                    <li class="nav-item"><a class="nav-item-link" href="shajareh.php">نمایش شجره نامه</a></li>
					<li class="nav-item"><a class="nav-item-link" href="shajarehTree.php">خاندان</a></li>
					<li class="nav-item"><a class="nav-item-link" href="relations.php">مشاهده وابستگان</a></li>
					<li class="nav-item"><a class="nav-item-link" href="editProfile.php">ویرایش پروفایل</a></li>
                    <li class="nav-item"><a class="nav-item-link" href="changepass.php">تغییر رمز عبور</a></li>
					<?php  
					$roleid = $_SESSION["roleid"];
					if( $roleid> 1)
						echo '<li class="nav-item"><a class="nav-item-link" href="../employees/profile.php">پنل کارمندی</a></li>';
					if($roleid > 2)
						echo '<li class="nav-item"><a class="nav-item-link" href="../admins/profile.php">پنل مدیریت</a></li>';
					 ?>
                    <li class="nav-item"><a class="nav-item-link" href="../../logout.php">خروج</a></li>
                                    </ul>
            </nav>
        </div><div class="content pivot grid">
	<div class="full12">
    	<div class="block grid12">
        	<h1 class="block-header"><?php echo $page  ?></h1>
            <div class="separator"></div>
            <div class="fluid" style='min-height:400px;'>
            	
            	<?php  echo $cnt ?>
            </div>
        </div>
    </div>
    
			
        </div>
        <footer class="footer">
        	
            <div class="pivot grid">
            <!--<div class="columns count5">-->
            	<div class="columns">
                    <div class="column">
                    	<h3>اطلاعات</h3>
                        <ul>
                       		<li><span>\</span><a href="aboutus.html">درباره ما</a></li>
                            <li><span>\</span><a href="#">درباره سایت</a></li>
                            <li><span>\</span><a href="#">پشتیبانی سایت</a></li>
                        </ul>	
                    </div>
                    <div class="column">
                    	<h3>خدمات به مشتری</h3>
                        <ul>
                       		<li><span>\</span><a href="contactus.html">تماس با ما</a></li>
                            <li><span>\</span><a href="#">بازخوردها</a></li>
                            <li><span>\</span><a href="#">نقشه سایت</a></li>
                        </ul>	
                    </div>
                   
                    <div class="column">
                    	<h3>ناحیه کاربری</h3>
                        <ul>
                       		<li><span>\</span><a href="account.html">ناحیه کاربری من</a></li>
                            <li><span>\</span><a href="#">لیست انخاب من</a></li>
                            <li><span>\</span><a href="#">عضویت در خبرنامه</a></li> 
                        </ul>	
                    </div>
                    <div class="column">
                    	
                                                <fb:fan profileid="109822959866" stream="0" connections="5" logobar="0" width="160" height="80" css="http://kos9.scompiler.ru/files/facebook.css?1361464408"></fb:fan>	
                                            </div>
                </div>
            </div>
            <div class="copyright"  style="padding-bottom:30px;">
            	<div class="grid grid12">
                    <div class="float-right">طراحی و توسعه<a href="#">  ساسان پارسافر و لیلا اسلامی </a></div>
                    
                </div>
            </div>
        </footer>
	</body>

<!-- Mirrored from kos9.scompiler.ru/ds2html/ by HTTrack Website Copier/3.x [XR&CO'2010], Mon, 25 Feb 2013 13:40:51 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
</html>