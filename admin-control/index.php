<?php
require_once('../system/config.php');
$myDb = new PDODatabase();

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
	} else {

	}

	return false;
}

$x = isLogged($myDb);
//echo $x;die();
if ($x)
	forceRedirect('home.php');
if (isset($_POST['login'])) {
	//Write code here for user validation...
	$strName = getREQUEST('username');
	$strPass = getREQUEST('password');
	if (!empty($strName) || !empty($strPass)) {
		$strSql = 'select * from us01users where us01username = "' . $strName . '"';

		$strResult = $myDb->db->query($strSql);

		if ($strResult->rowCount() >= 1) {

			//echo 'password match';die();
			$arrUserInfo = $strResult->fetchAll(PDO::FETCH_ASSOC);
			if (sha1(md5(sha1($strPass))) == $arrUserInfo[0]['us01password']) {
				$_SESSION['LOGIN_ID'] = $arrUserInfo[0]['us01username'];
				// echo mysql_num_rows($strResult);                die();

				header('location:index.php');
			}

			//var_dump($arrUserInfo);die();
			//$arrUserInfo = mysql_fetch_assoc( $strResult );
		} else {
			$objMsg->set('Login failed !!!', 1);
		}
	} else {
		$objMsg->set('Login failed !!!', 1);
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Administrative Login</title>
        <link  href="../css/bootstrap/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link  href="../css/admin/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <link  href="../css/admin/styles.css" rel="stylesheet" type="text/css"/>

    </head>
    <body>

		<div id="templatemo_header_wrapper">
			<div id="templatemo_header">
				<div id="site_title" >
					<!--
					<a href="index.php"><img src="img/_logo.png" height="50" width="50" />

			<img src="img/_logo.png" height="120" width="120" /><img src="img/kcmlogo.jpg" height="120" width="330" />
					-->
					<span class="TitleText1" >admin <em>panel</em></span>
					</a></div>

			</div> <!-- END of header -->
		</div>

        <div class="Wrapper">
            <div class="WrapperContent" id="mainContentWrapper" >
                <div id="" >
					<h2></h2>

					<form action="" method="post" name="myform" id ="target">
						<div id="">
							<div class=""><br />
								<br />
								<div class="row">
									<div class="col-sm-offset-4 col-sm-4">
<?php
include_once(ADMIN_TPL_MODULE . 'includes/message.php');
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h1 class="panel-title" ><img src="../images/logo.png" height="40" style="margin-right: 20px;" /><?php echo APP_NAME; ?> </h1>
											</div>

											<div class="panel-body">

												<div class="alert alert-success" style="display: none;"><i class="fa fa-check-circle"></i> <?php echo 'success'; ?>
													<button type="button" class="close" data-dismiss="alert">&times;</button>
												</div>

												<div class="alert alert-danger" style="display: none;"><i class="fa fa-exclamation-circle"></i> <?php echo 'warning'; ?>
													<button type="button" class="close" data-dismiss="alert">&times;</button>
												</div>

												<form action="" method="post" enctype="multipart/form-data">
													<div class="form-group">
														<label for="input-username">Username</label>
														<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
															<input type="text" name="username" value="" placeholder="Username" id="input-username" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label for="input-password">Password</label>
														<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
															<input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" />
														</div>

														<span class="help-block" style="display: none;"><a href="#">Forgot Password</a></span>

													</div>
													<div class="text-right">
														<button type="submit" name="login" class="btn btn-primary"><i class="fa fa-key"></i> Login</button>
													</div>

												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


					</form>
                </div>


            </div>

            <!--- footer section --->
            <div class="cleaner"></div>
			<div id="templatemo_footer_wrapper" class="container" >
				<div id="templatemo_footer">




                    <div class="">
						<center>
							Copyright &copy; <?php echo date("Y") . ' ' . APP_NAME; ?>  All Rights Reserved.
                            <br />

                        </center>

                    </div>

					<div class="cleaner"></div>
                </div>
            </div> <!-- END of footer -->
        </div>

    </body>
</html>