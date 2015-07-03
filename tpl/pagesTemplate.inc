<?php
$module = 'pageModule';
if (isset($_GET['page']))
	$module = $_GET['page'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo APP_NAME; ?></title>
		<base href="<?php echo BASE_URL; ?>" target="_parent"/>
		<script src="js/admin/custom.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo APP_META_DESC; ?>">
		<meta name="keywords" content="<?php echo APP_KEYWORDS; ?>"/>
		<meta name="author" content="<?php echo BASE_URL; ?>">
		<!-- Bootstrap -->
		<link href="css/themes/bootstrap.css" rel="stylesheet">
		<link href="css/themes/style.css" rel="stylesheet">
		<link href="css/themes/responsive.css" rel="stylesheet">
		<link href="css/themes/font-awesome.css" rel="stylesheet">
		<link href="css/fonts/fonts.css" rel="stylesheet">
		<link href="css/themes/webticker.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,500' rel='stylesheet' type='text/css'>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="js/html5shiv.js"></script>
		  <script src="js/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/themes/jquery.min.js"></script>
		<script src="js/themes/jquery.modern-ticker.min.js"></script>
		<script src="js/themes/bootstrap.min.js"></script>
		<link href="css/themes/jquery.fancybox.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>

	</head>
	<body>



		<?php echo loadModule('mainHeader'); ?>





		<div class="content" >

			<div class="container">
				<div class="row">
					<!-- header end -->

					<div class="col-md-12">
						<div class="news-heading">
							<?php echo loadModule($module); ?>
						</div>
					</div>


				</div>
			</div>

		</div>


		<?php echo loadModule('mainFooter'); ?>




	</body>
</html>