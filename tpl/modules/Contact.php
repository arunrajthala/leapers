<?php
$objMail= new Message();
$SQL='select * from set01settings limit 0,1 ';
$prefix1='set01';
$_data=Query($SQL);
include 'securimage/securimage.php';
 foreach($_data as $row):
    $set01email=$row['set01email'];
 endforeach;
  ?>
<?php
        $EmailOutput='';
        $author='';
        $email='';
        $subject='';
        $message='';
        $phone='';
        if(isset($_POST['txtauthor']))
            $author=$_POST['txtauthor'];
        if(isset($_POST['txtemail']))
            $email=$_POST['txtemail'];
        if(isset($_POST['txtphone']))
            $phone=$_POST['txtphone'];
        if(isset($_POST['txtmessage']))
            $message=$_POST['txtmessage'];
        
        if(isset($_POST['submit']))
        {
            $valid = $capObj->check($_POST['code']);
            //var_dump($_POST);
            if(trim($_POST['txtauthor'])=='')
            {
                $EmailOutput='Name Required';
            }
            elseif($_POST['txtemail']=='')
            {
                
                $EmailOutput='Email Required';
            }
             elseif(trim($_POST['txtmessage'])=='')
            {
                $EmailOutput='Message Required';
            }  
             elseif(trim($_POST['txtphone'])=='')
            {
                $EmailOutput='Phone Number Required';
            }   
            elseif(!$valid)
            {
                $EmailOutput='Wrong Captcha Code';
            } 
            else
            {
                //check for correct email address 
                //$author=$_POST['txtauthor'];
                //$email=$_POST['txtemail'];
                //$phone=$_POST['txtphone'];
                $subject='Email from '.APP_NAME.'client: '.$author;
                //$message=$_POST['txtmessage'];
                //$author=$_POST['txtauthor'];
                $mailResult=$objMail->sendMailToSystem(APP_EMAIL,$subject,$email);
                if($mailResult)
                {
                    $EmailOutput='Message Sent. Thank you for your precious time';
                    $author='';
                    $email='';
                    $subject='';
                    $message='';
                }
                    
                else
                    $EmailOutput='Message not sent ';
                //$output='Bravo';
            }
            
            
        }    
 ?>
<div class="internal-news">
    <h2>Give Us Your Feedback </h2>
</div>
<div class="contact-form">
    <?php
                        if($EmailOutput !=""):
                       ?>
                        <ul class="address-lists1" style="width: 100%;">
                            <li>
                                <p style="color: red;"><b> <?php echo $EmailOutput ?> </b></p>
                            </li>
                        </ul>
                        <?php endif; ?>
                    <form role="form" method="post" class="" autocomplete="on">
                        <h2 class="form-signin-heading">Contact Form</h2>
                        <div class="form-group">
                        <label for="exampleInputName">Full Name : </label>
                        <input value="<?php  echo $author ?>" required name="txtauthor" type="text" class="form-control" id="exampleInputName">
                        </div>
                        <div class="form-group">
                        <label for="exampleInputEmail">Email Address : </label>
                        <input value="<?php  echo $email ?>" required name="txtemail" type="email" type="email" class="form-control" id="exampleInputEmail">
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPhone">Phone : </label>
                        <input value="<?php  echo $phone ?>" required name="txtphone" type="text" type="tel" class="form-control" id="exampleInputPhone">
                        </div>
                        <div class="form-group">
                        <label for="exampleInputMsg">Message : </label>
                        <textarea name="txtmessage" class="form-control" rows="3" required><?php if (isset($_POST['txtmessage'])) echo $_POST['txtmessage'] ?> </textarea>
                        
                        </div>
                        <div style="float:left; margin-bottom: 10px; width: 100%;">
                                <img height="64px" width="120px" id="siimage" style="border: 1px solid #000; margin-right: 15px" src="securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
                                <object type="application/x-shockwave-flash" data="securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=securimage/images/audio_icon.png&amp;audio_file=securimage/securimage_play.php" height="32" width="32">
                                <param name="movie" value="securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=securimage/images/audio_icon.png&amp;audio_file=securimage/securimage_play.php" />
                                </object>
                                &nbsp;
                                <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = 'securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="securimage/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0"></a>
                                <strong style="display: inline-block;">Enter Code*:</strong>
                                <input type="text" name="code" size="12" maxlength="16" style="display:inline-block;" />
                            </div>
                        <button  name="submit" type="submit" class="btn btn-default">Submit</button>
                            <!--
        <h2 class="form-signin-heading">Inquiry Form</h2>
                            <input value="<?php  echo $author ?>" name="txtauthor"  type="text" class="form-control" id="title" placeholder="Enter Your Full Name" required  autofocus />
                            <input value="<?php  echo $email ?>" name="txtemail" type="email" class="form-control" id="email" placeholder="Enter Your Email" required>
                            <textarea name="txtmessage" class="form-control" rows="10" style="height:100px !important;" required><?php if (isset($_POST['txtmessage'])) echo $_POST['txtmessage'] ?> </textarea>
                            
                            <button class="btn btn-lg btn-danger" type="submit">Submit</button>
        -->
                    </form>
</div>
<div class="col-md-8">
				<div class="contact">
					<h4>Contact Us</h4>
						<p><span><?php echo APP_NAME ?></span>
		<?php echo APP_ADDRESS ?><br/>
		Phone: <?php echo APP_PHONE ?> ,<?php echo APP_PHONE_2 ?>
        <a href="mailto:<?php echo APP_EMAIL; ?>"><?php echo APP_EMAIL; ?></a>
		<br/>
		
		</p><br/>
					</div>
				
</div>	
 
    
 
