<?php
/*
$table='us02modules';
$prefix='us02';
$_id='us02uin';
$_fields=array($prefix.'uin', $prefix.'view',$prefix.'add',$prefix.'delete');
$db=new PDODatabase();
   
$db->setMasterData($table,$_fields,$prefix);*/
$db=new userModule();
$objMsg= new Message();
$prefix=$db->getPrefix();
$id=0;
if(isset($_GET['_Id']))
{
    $id=$_GET['_Id'];
    $data=$db->getByID($id);
}
if($id==0)
{
    //echo 'inserting';
    $db->setFieldValues('us01uin',getREQUEST('userId'));
    $db->setFieldValues('set02uin',getREQUEST('mod_id'));
    $id=$db->insert_core();
    if($id>0)
    {
        $objMsg->set('Update Successfull');
        //echo 'inserted';
    }
    //die();
    //redirect('?module=News');
}
//var_dump($data);
$view=$data[$prefix.'view'];
$add=$data[$prefix.'add'];
$delete=$data[$prefix.'delete'];
//var_dump($view);die();

//var_dump($data);die();
if(isset($_GET['action']))
{
    $type=$_GET['action'];
    echo $type;
    
    if($type==ACCESS_VIEW)
    {
        if($view)
        {
            $view=0;
        }
        else{
            //var_dump($view);die();
            $view=1;
        }
        
        $db->setFieldValues('view',$view);
        
    }
    elseif($type==ACCESS_ADD)
    {
        if($add)
        {
            $add=0;
        }
        else{
            $add=1;
        }
        $db->setFieldValues('add',$add);
    }
    elseif($type==ACCESS_DELETE)
    {
        if($delete)
        {
            $delete=0;
        }
        else{
            $delete=1;
        }
        $db->setFieldValues('delete',$delete);
    }
    
    
    
    
//var_dump($db);die();
    $result =$db->update_core($id);//die();
    //var_dump($result);
    if($result)
    {
        $objMsg->set('Update Successfull');
        //echo '<script>alert("");</script>';
        
    }
    else
    {
        
        $objMsg->set('Update not Successfull');
    }
    forceRedirect('?module=userModule&_Id='.getREQUEST('userId'));
        die();
    
    
    
    
}

//redirect('?$module='.$_GET['module']);
?>