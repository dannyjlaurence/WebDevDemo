<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

 
<title>Web Dev- Home</title>
<link rel="stylesheet" type="text/css" href="/webdev/myCSS.css" />
<style>
p{
 color:green;
}
</style>
</head>

<body>
	<!--
	<p><a href="https://www.apachefriends.org/index.html">XAMPP</a></p>
	<p><a href="https://mac.github.com/">GitHub Application for Mac</a></p>
	<p><a href="https://windows.github.com/">GitHub Application for Windows</a></p>
	<p><a href="presentation.pptx">Today's presentation</a></p>
	<p><a href="contactus.html">contact us</a></p>-->
	<div id="truth">
		<?php
			$i = 0; 
			
			while ($i < 100){
				echo "<marquee>Hello world</marquee>";
					$i = $i + 1;
			}
		?>
	</div>
	</body>
</html>
