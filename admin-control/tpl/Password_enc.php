
<?php //var_dump($obj) 
if(isset($_POST['sub']))
{
    $objMsg= new Message();
    $objMsg->set('Encrypted Password: '.sha1(md5(sha1($_POST['password']))).' ');
}
    
?>
<div class="headline">Password Encryptor</div>
<?php
    
   include_once(ADMIN_TPL_MODULE.'includes/message.php');
?>
<form method="post" enctype="multipart/form-data">

    <div class="top_bar">
        
    </div>
    
        <div class="cleaner"></div>
                    <div class="subhead">
    				    <table width="100%" cellspacing="0" cellpadding="0" class="admTable table">
                            <tbody>
                                
                                <tr>
                                    <td>
                                        <label >Password: </label>
                                    </td>
                                    <td>
                                        <input required  class="input_field"  type="Text" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>"  name="<?php echo 'password';?>">
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <label>&nbsp;</label>
                                    </td>
                                    <td>
                                        <input type="submit" class="submit" value="Update" name="sub"><input type="button" class="submit" onclick="history.back();" value="Back" name="cmdBack">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
    				</div>
        

  </form>