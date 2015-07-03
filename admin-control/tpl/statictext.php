<?php
    $details='';
    $title='';  
    if(isset($_POST['sub']))
    {
        //var_dump($_POST);
        for($i=1;$i<=4;$i++)
        {
            echo $_POST['title'.$i];
            if(Query("update static set title='".$_POST['title'.$i]."', details='".$_POST['det'.$i]."' where st_id=".$i))
                echo 'Update Successful !';
            else
                echo 'Update Unsuccessful';
        }
    }
?>
<form enctype="multipart/form-data" action="" method="post">
    <table  border="0">
<?php
    $data=Query("select * from static");
     foreach($_data as $row)
    {
        switch ($row['st_id']){ 
        	case 1:
                $title='Welcome Note';
        	   break;
        	case 2:
                $title='Homepage Note';
        	   break;
        	case 3:
            $title='History Note';
        	   
        	break;
        
        	default :
                $title='Contact Info ';
        }  
        
            
        
?>
        <tr>
            <td colspan="2"><hr /></td>
        </tr>
        <tr>
        <th colspan="2"><?php echo $title ?></th>
        
        </tr>
	  <tr>
		<td>Title</td>
		<td><input type="text" value="<?php echo $title; ?>" name="title<?php echo $row['st_id'];?>" /></td>
	  </tr>
      <tr>
		<td>Details</td>
		<td><textarea  class="ckeditor"name="det<?php echo $row['st_id'];?>" ><?php echo $row['details'];?></textarea></td>
	  </tr>
	  <tr>
		<td>Image</td>
		<td><input class="input_field" name="file<?php echo $row['st_id'];?>" type="file"  /></td>
	  </tr>
      
<?php
    }
?>
     <tr>
	     
		<td><input name="sub" type="submit" class="submit"  value="Submit"  /></td>
		<td><input  type="reset"  class="submit"   /></td>
	  </tr>
	</table>
		

</form>