<?php
    require_once('system/config.php');
    if(!(getREQUEST('module')&& getREQUEST('file_name')))
    {
        echo 'no module or type or filepath';
        //forceRedirect(BASE_URL);
        die();
    }
    
    $path=getREQUEST('module');
    $file=getREQUEST('file_name');
    
    //if(file_exists($file))
    {
        $allowed_type=array('doc','docx','pdf');
        if(in_array($Type,$allowed_type))
        {
            Force_Downlaod($path,$file,'Notice');
            die();     
        }
    }
    
    forceRedirect(BASE_URL);
   
?>