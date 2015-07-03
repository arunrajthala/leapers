<?php
/* $objtest=new Programs();
  var_dump($objtest);
  $test=$objtest->getOnAir();
  var_dump($test);die(); */
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <script src="js/admin/custom.js"></script>
        <title><?php echo APP_NAME; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo APP_META_DESC; ?>">
		<meta name="keywords" content="<?php echo APP_KEYWORDS; ?>"/>
		<meta name="author" content="BASE_URL">
		<!-- Bootstrap -->
		<link href="css/themes/bootstrap.css" rel="stylesheet">
		<link href="css/themes/style.css" rel="stylesheet">
		<link href="css/themes/responsive.css" rel="stylesheet">
		<link href="css/themes/font-awesome.css" rel="stylesheet">
		<link href="css/fonts/fonts.css" rel="stylesheet">
		<link href="css/themes/webticker.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,500' rel='stylesheet' type='text/css'>
		<!--

		<link href="css/themes/reset.css" rel="stylesheet">
		<link href="css/themes/bootstrap.min.css" rel="stylesheet">
		<link href="css/themes/modern-ticker.css" rel="stylesheet">
		<link href="css/themes/style.css" rel="stylesheet">
		-->

		<script src="js/themes/jquery.min.js"></script>
		<script src="js/themes/jquery.modern-ticker.min.js"></script>
		<script src="js/themes/bootstrap.min.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>

	</head>

	<body>



		<?php echo loadModule('mainHeader'); ?>





		<div id="content" >

			<!-- header end -->
			<?php echo loadModule('HomeContent'); ?>

		</div>

		<?php echo loadModule('mainFooter'); ?>


		<!-- basic js -->
		<!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script> -->

	</body>

</html>