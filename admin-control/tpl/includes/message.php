<?php
    $objMsg= new Message();
    $msg=$objMsg->DisplayMsg();
    //var_dump($msg);
    if($msg[0])
    {
        if(! $msg[1])
        {
?>            <div class="alert alert-success">
					<i class="fa fa-thumbs-o-up">
					</i>
					<?php echo $msg[0]; ?>
					<strong>
						!
					</strong>
					
					
				</div>
            
<?php            
        }
        else
        {
?>        <div class="alert alert-danger">
					<i class="fa fa-exclamation-circle">
					</i>
					<?php echo $msg[0]; ?>
					<strong>
						!
					</strong>
					
					
				</div>
            
<?php           
        }
    }
    return;

    $objMsg= new Message();
    $msg=$objMsg->DisplayMsg();
    if($msg[0])
    {
        if($msg[1])
        {
?>            <div class="headline1"><?php echo $msg[0]; ?></div>
            
<?php            
        }
        else
        {
?>        
                <div class="headline1"><?php echo $msg[0]; ?></div>
    
            
<?php           
        }
    }
    else
    {
        //echo 'no message';
    }
?>