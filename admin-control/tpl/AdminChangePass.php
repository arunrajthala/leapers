<!-- here goes the ouitput format -->
<div class="cleaner"></div>
<div class="headline">Change Password </div>
<div class="top_bar">
    <a href="home.php?module=setting&action=setting"><img src="../css/img/settings.png" height="32px" width="32px"/>Site Setting</a>
    <a href="home.php?module=setting&action=addcontrol"><img src="../css/img/add.png" height="32px" width="32px"/>Add Site Admin</a>
    <a href="home.php?module=AdminChangePass"><img src="../css/img/changepass.png" height="32px" width="32px"/>Change Password</a>
    <!--
<a href="home.php?module=setting&action=logo"><img src="../css/img/edit.png" height="32px" width="32px"/>Change Logo</a>
-->
    <!--
<a href="home.php?module=page"><img src="../css/img/add.png" height="32px" width="32px"/>Add Page</a>
-->
</div>
<?php
    if (isset($_POST['sub']))
    {
        $strSQL = 'select * from us01users where us01username = "'.$_SESSION['LOGIN_ID'].'"';
        $result=Query($strSQL);
        $row=$result[0];
        if($row['us01password']==sha1(md5(sha1($_POST['pass']))))
        {
            if($_POST['pass1']==$_POST['pass2'] && $_POST['pass2']!="")
            	{
            	   $SQL= "update us01users set us01password='".sha1(md5(sha1($_POST['pass1'])))."' where us01username='$_SESSION[LOGIN_ID]' ";
                	//echo $SQL;
                    $id=Query($SQL);
                    //var_dump($id);
                    if($id)
                		echo '<div class="headline1"> Password Changed !</div>';
                	else
                		echo '<div class="headline1"> Update Unsuccessfull !</div>';
            	}
        	else
        		echo '<div class="headline1"> New Password and Confirm password does not match !</div>';
         }
         else
            echo '<div class="headline1"> Old Password incorrect !</div>';
    }
?>
<div class="cleaner"></div>
<div class="subhead">
    <form action="" method="post">
    <table class="admTable table">
        <tr>
    	<td>Old Password</td>
    	<td><input class="input_field" name="pass" type="password" /></td>
      </tr>
        <tr>
    	<td>New Password</td>
    	<td><input class="input_field" name="pass1" type="password" /></td>
      </tr>
      <tr>
    	<td>Confirm Password</td>
    	<td><input class="input_field" name="pass2" type="password" /></td>
      </tr>
      <tr>
    	<td><input name="sub" type="submit" class="submit"  value="Submit" /></td>
    	<td></td>
      </tr>
    </table>
    </form>
</div>