<?php //var_dump($_data); ?>
<div class="headline">Reset <?php echo $_data['us01username'] ?>'s password</div>
<?php
    
   if($message)
    {
        echo '<div class="headline1">'.$message.'</div>';
    } 
?>
<form method="post">
Are you sure?? you want to reset the password of user <?php  ?>
    <input type="submit" name="sub" value="Yes" />
    <input type="submit" name="negative"  value="No" />
</form>