<?php

    /*$SQL='Alter table set01settings CHANGE uin set01uin int(10)';
    $res=Query($SQL);
    if($res)
    {
        echo 'operation successful';
    }
    else
    {
        echo 'error updating table';
    }*/
    $logo_directory='../uploads/logo/';
    $objMsg=new Message();
?>
<div class="headline">Admin User Setting</div>
<div class="subhead">

<?php
    if (isset($_POST['sub']))
    {
        $action='setting';
        if(isset($_GET['action']))
            $action=$_GET['action'];
        if($action=='logo')
        {
            if ((($_FILES["std_img1"]["type"] == "image/gif")|| ($_FILES["std_img1"]["type"] == "image/jpeg"|| ($_FILES["std_img1"]["type"] == "image/png")|| ($_FILES["std_img1"]["type"] == "image/pjpeg"))&& ($_FILES["std_img1"]["size"] < 2000000)))
    		{
				   unlink($logo_directory."logo.png");
                   //if(uploadfile('std_img1','_logo.png','_logo.png','../img',200,200))
                   if(move_uploaded_file($_FILES["std_img1"]["tmp_name"],$logo_directory."logo.png" ))
                   {
                        echo '<div class="headline1">Logo Changed Successfully !!!</div>';
                        ar_imageresize($logo_directory."logo.png",200,200);
                   }
                    
                   else
                    echo '<div class="headline1">Failed to change logo  !!!</div>';
    				   //echo "Stored in: " . "../image/" .$d.".".$a;
    		 }
        }
		elseif($action =='addcontrol')
		{
			if($_POST['adm_pass1']==$_POST['adm_pass2'])
    		{
    		      $strSQL = 'select * from us01users where us01username = "'.$_POST['adm_name'].'"';
    			$result=Query($strSQL);
    			
    			if(count($result))
    			{
    				echo '<div class="headline1">Duplicate Name !</div>';
    			}
    			else
    			{
    			 $pass=sha1(md5(sha1($_POST['adm_pass1'])));
                 $SQL="INSERT INTO us01users (us01username,us01password,us01us00uin) VALUES ('$_POST[adm_name]','$pass',100)";
    				if(Query($SQL))
    					echo '<div class="headline1">Admin Created Successfully !</div>';
    				else
                    {
                        //echo $SQL;
                        echo '<div class="headline1"> Admin not Created !!</div>';
                    }
    					
    			}
    		}
            
    		else
    		{
    			echo '<div class="headline1">New Password and Confirm Password doesnt match !</div>';
    		}
		}
        elseif($action=='setting')
        {
            
            
            $db= new Setting();
            
            $result = $db->update(1,$_POST);
            if($result)
    					$objMsg->set( 'Setting updated Successfully !');
    				else
    					$objMsg->set( ' Setting not updated !!');
        }
        else
        {
            
        }
        forceRedirect(getCurrentURL());
        
    }
?>
<?php
    
   include_once(ADMIN_TPL_MODULE.'includes/message.php');
?>  
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
<dir class="clear"></dir>
<form method="post" enctype="multipart/form-data">
<?php
    $action='setting';
    if(isset($_GET['action']))
        $action=$_GET['action'];
    //if (isset($_GET['action'])):
?>
<?php
    
    if ($action=='addcontrol')
    {
?>
                     <table  border="0" class="table">
                     <tr><th colspan="2"> Add Admin</th></tr>
						  <tr>
							<td>Admin name</td>
							<td><input class="input_field" name="adm_name" type="text" /></td>
						  </tr>
						  <tr>
						  <tr>
							<td>Password</td>
							<td><input class="input_field" name="adm_pass1" type="password" /></td>
						  </tr>
						  <tr>
							<td>Confirm Password</td>
							<td><input class="input_field" name="adm_pass2" type="password" /></td>
						  </tr>
						  <tr>
							<td><input name="sub" type="submit" class="submit"  value="Submit" /></td>
							<td><input  type="reset" class="submit"/></td>
						  </tr>
						</table>
<?php        
    }
    if ($action=='logo')
    {
?>
                     <table  border="0">
                     <tr><th colspan="2"> Change Logo</th></tr>
						  <tr>
							<td>Choose Logo:</td>
							<td><input class="input_field" name="std_img1" type="file" /><img src="<?php echo $logo_directory; ?>logo.png" height="100px" width="100px" /></td>
						  </tr>
						  <tr>
							<td><input name="sub" type="submit" class="submit"  value="Submit" /></td>
							<td><input  type="reset" class="submit"/></td>
						  </tr>
						</table>
<?php        
    }
    if ($action=='setting')
    {
        $objSetting= new Setting();
        $data=$objSetting->getByID(1);
        
?>
                     <table class="admTable table"  border="0">
                     <tr><th colspan="2"> Site Setting</th></tr>
						  <tr>
							<td>Site Admin Email:</td>
							<td><input  class="input_field"  name="email" type="email" required value="<?php echo $data['set01email']; ?>" /><i> * email will be sent to this email-address</i></td>
						  </tr>
                          <tr>
							<td>Site Name:</td>
							<td><input  required  class="input_field" name="name" type="text" required value="<?php echo $data['set01name']; ?>" /></td>
						  </tr>
                          <tr >
							<td>Facebook Page ID:</td>
							<td><input  required  class="input_field"  name="url" type="text" value="<?php echo $data['set01url']; ?>" required /></td>
						  </tr>
                          <tr>
							<td>Contact Number 1:</td>
							<td><input  required  class="input_field"  name="tel1" type="text" value="<?php echo $data['set01tel1']; ?>" required /></td>
						  </tr>
                          <tr>
							<td>Contact Number 2:</td>
							<td><input    class="input_field" name="tel2" type="text" value="<?php echo $data['set01tel2']; ?>"  /></td>
						  </tr>
                          <tr>
							<td>Address 1:</td>
							<td><textarea class="ckeditor" name="address" required ><?php echo $data['set01address']; ?> </textarea></td>
						  </tr>
                          <tr>
							<td>Address 2:</td>
							<td><textarea class="ckeditor" name="address2" ><?php echo $data['set01address2']; ?> </textarea></td>
						  </tr>
                          <tr>
							<td>Fax :</td>
							<td><input    class="input_field" type="text" name="fax" value="<?php echo $data['set01fax']; ?>" /></td>
						  </tr>
                          <tr>
							<td>Background:</td>
							<td><textarea class="ckeditor" name="about" ><?php echo $data['set01about']; ?> </textarea></td>
						  </tr>
                          
						  <tr>
							<td><input name="sub" type="submit" class="submit"  value="Submit" /></td>
							<td><input  type="reset" class="submit"/></td>
						  </tr>
						</table>
<?php        
    }
    if ($action=='page')
    {
?>
                     <table  border="0">
                     <tr><th colspan="2"> Add Page</th></tr>
						  <tr>
							<td>Menu Name:</td>
							<td><input name="mnu_name" type="text" /></td>
						  </tr>
						   <tr>
							<td>Page  Details:</td>
							<td><textarea  class="ckeditor"name="mnu_details"  class="ckeditor" ></textarea></td>
						  </tr>
						  
							
						  <tr>
							<td><input name="_addmnu" type="submit" class="submit"  value="Submit" /></td>
							<td><input  type="reset" class="submit"/></td>
						  </tr>
						</table>
<?php        
    }
    //if action ==about
?>









<?php //endif ?>
</form>
</div>