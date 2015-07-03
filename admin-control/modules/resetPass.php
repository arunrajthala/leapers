<?php
    /***************** these fields are required ************************************/
    //die();
    //var_dump($MyModules);
    $objUser = new Users();
    $data['message']='';
    $id=0;
    $id=getREQUEST('_Id');
    if( getREQUEST('sub'))
    {
        
        //$id=getREQUEST('_Id');
        $newPass=$objUser->reset_Password($id);
        if($newPass)
        {
            $data['message']='Password Changed Successfully. New password is '.$newPass;
        }
        else
        {
            $data['message']='Problem Resetting password !!!' ;
        }
        
        
    }
    elseif(getREQUEST('negative'))
    {
        forceRedirect('home.php?module=Users');
    }
    //echo $id;
    $data['_data']=$objUser->getByID($id);
    //var_dump($data);
    echo defaultAdminModule( $strModuleName, $data );
    
?>