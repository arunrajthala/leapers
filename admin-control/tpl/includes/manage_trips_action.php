<?php
//die();
if(isset($_GET['_Id']))
    {
        $row=$obj->getByID($_GET['_Id']);
    }
    if(isset($_GET['delete']))
    {
        $result=$obj->getByID($_GET['_Id']);
        if($result)
        {
            if($filename!='')
                unlink('../image/'.$filename);
            echo '<div class="headline1">Page Deleted  Successfully !</div>';
        }
            
		else
			echo '<div class="headline1"> Page not Deleted !!!</div>';
            
    }
    
    ?>