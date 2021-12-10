<!DOCTYPE html>
<html>
<head>
	<title>Truyện hay</title>
	<script src="https://kit.fontawesome.com/141da4893d.js" crossorigin="anonymous"></script>
	<?php include 'style.css'; ?>
	<style type="text/css">
	
		#div_giua{
			width: 100%;
			height: 83%;
			/*background: green;*/
			position: absolute;
			top: 80px;
			
		}
		#div_giua >.trai{
			width: 15%;
			height: 100%;
			/*background: blue;*/
			float: left;
		}
		#div_giua >.giua{
			width: 70%;
			height: 100%;
			/*background: grey;*/
			float: left;
		}
		#div_giua >.phai{
			width: 15%;
			height: 100%;
			/*background: orange;*/
			float: left;
		}
		#div_duoi{
			width: 100%;
			height: 7%;
			/*background: darkgreen;*/
			position: absolute;
			bottom: 0px;
		}
		a{
			text-decoration: none;
			color: #E4E6EB;
		}
		
	</style>
</head>
<body>
	<div id="div_tong">
		<?php include 'menu.php' ?>
		<?php include 'contents.php' ?>
		<?php include 'footer.php'  ?>
	</div>
</body>
</html>