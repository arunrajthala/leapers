<?php
/**
 * @author Arun Rajthala
 * @copyright 2011
 * */
require_once('../system/config.php');
require('../system/UserModule.php');
//Connect();
$currUser = new Users();
$myDb = new PDODatabase();
$objUserModule = new userModule();
$data['objUserModule'] = $objUserModule;
$CrossResult = false;
$data['MyModules'] = array();
//var_dump($objUserModule);
$strModule = getREQUEST('module');
//echo $strModule;
if ($strModule) {
	$CrossResult = $objUserModule->CrossCheck($strModule);
	//var_dump($CrossResult);die();
	if (!$CrossResult[0]) {
		$strModule = UNAUTHORIZED;
	} else {
		//echo 'i m true';
		//die();
		if (!$CrossResult[ACCESS_VIEW]) {
			//var_dump(getREQUEST('action'));
			//if()
			$strModule = UNAUTHORIZED;
			if (getREQUEST('action') == '') {
				$strModule = UNAUTHORIZED;
			}
		}
		$action = getREQUEST('action');
		if (!$CrossResult[ACCESS_ADD]) {
			if ($action == 'add' || $action == 'edit') {
				$strModule = UNAUTHORIZED;
			}
		}
		if (getREQUEST('delete') == 1) {
			if (!$CrossResult[ACCESS_DELETE])
				$strModule = UNAUTHORIZED;
		}
	}
}
//var_dump($objMsg);
if (isset($_GET['logout'])) {
	unset($_SESSION['LOGIN_ID']);
	forceRedirect('index.php');
}

//var_dump($data);
function isLogged($db)
{
	if (isset($_SESSION['LOGIN_ID'])) {

		$strSQL = 'select * from us01users where us01username = "' . $_SESSION['LOGIN_ID'] . '"';
		//$strSQL = 'select * from controller where user = "'.$_SESSION['LOGIN_ID'].'"';
		$strResult = $db->db->query($strSQL);
		//var_dump($arrResult);die();
		if ($strResult->rowCount() >= 1) {
			$GLOBALS['arrUserInfo'] = $strResult->fetchAll(PDO::FETCH_ASSOC);
			return true;
		}
	}
	return false;
}

$x = isLogged($myDb);

if ($x === false)
	forceRedirect('index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Admin Panel : <?php echo APP_NAME; ?></title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link  href="<?php echo BASE_URL; ?>css/bootstrap/bootstrap.css" rel="stylesheet" type="text/css"/>
		<!--
		<link href="../css/admin/templatemo_style.css" rel="stylesheet" type="text/css" />
		-->
		<link href="<?php echo BASE_URL; ?>css/admin/dataTables.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo BASE_URL; ?>css/admin/styles.css" rel="stylesheet" type="text/css" />

		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/admin/ddsmoothmenu.css" />
		<script src="<?php echo BASE_URL; ?>js/admin/jquery-1.7.2.min.js"></script>
		<!--
		<script type="text/javascript" src="../js/admin/jquery.min.js"></script>
		-->
		<script src="<?php echo BASE_URL; ?>js/bootstrap/bootstrap.min.js"></script>
		<script src="<?php echo BASE_URL; ?>js/admin/jquery.kwicks-1.5.1.pack.js" type="text/javascript"></script>
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		<script src="<?php echo BASE_URL; ?>js/admin/dataTables.js"></script>
		<script src="<?php echo BASE_URL; ?>js/admin/data_manager.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL ?>js/admin/jquery-ui-1.8.21.custom.min.js"></script>



	</head>

	<body>
		<div id="top-bar" class="container">
			<div class="row" style="margin: 0px;">
				<div class="span12">
                    <div id="templatemo_header_wrapper">
						<div id="site_title" class="col-md-3" >
							<a href="home.php" class="selected">
								<img src="../images/logo.png" height="65"  style="margin-right: 20px;max-width: 250px;" />
							</a>
						</div>
						<div id="" class="ddsmoothmenu1 col-md-8">
							<ul>
								<li><a href="home.php" class="selected">Welcome <?php echo $_SESSION['LOGIN_ID']; ?></a></li>
								<li><a href="home.php?module=AdminChangePass">Change Password</a></li>
								<li><a href="home.php?module=setting" > Setting </a></li>
								<li><a href="home.php?logout=true">Logout</a></li>
								<li><a href="../index.php"  target="_blank"> Go to the site &raquo; </a></li>
							</ul>
							<br style="clear: left" />
						</div> <!-- end of templatemo_menu -->
                    </div>
				</div>


			</div>
		</div>
		<div id="wrapper" class="container" style="margin-top: 10px;">
			<section class="main-content">
				<div class="row">
					<div class="col-md-3">
						<?php include(ADMIN_TPL_MODULE . 'includes/sidemenu.php'); ?>
					</div>
                    <div class="col-md-9">

						<?php $arrModules = array('AdminChangePass', 'AdminGuestBook'); ?>
						<?php if ($strModule == ""): ?>
							<div class="moduleWrapper" >
								<div class="moduleContent">

									<?php include(ADMIN_TPL_MODULE . 'includes/dashboard.php'); ?>
									<div style="clear: both;"></div>
								</div>
							</div>
						<?php else: ?>
							<?php echo loadAdminModule($strModule, $data); ?>
						<?php
						endif;
						?>
					</div>
				</div>
			</section>


		</div>

        <div id="wrapper" class="container">
            <div id="templatemo_footer_wrapper" class="container" >
				<div id="templatemo_footer">




                    <div class="">
						<center>
							Copyright &copy; <?php echo date("Y") . ' ' . APP_NAME; ?>  All Rights Reserved.

                        </center>

                    </div>

					<div class="cleaner"></div>
                </div>
            </div> <!-- END of footer -->
        </div>

    </body>
</html>