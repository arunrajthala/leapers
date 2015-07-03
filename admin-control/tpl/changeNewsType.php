<?php

$table='news02news';
$prefix='news02';
$_id='news02uin';
$_fields=array($prefix.'uin', $prefix.'highlight',$prefix.'featured',$prefix.'headline');
//$db=new PDODatabase();
$db= new News();
$objMsg= new Message();   
//$db->setMasterData($table,$_fields,$prefix);
$id=0;
if(isset($_GET['_Id']))
{
    $id=$_GET['_Id'];
}
//
if($id==0)
{
    redirect('?module=News');
}
$data=$db->getByID($id);
//var_dump($data);die();
$highlight=$data[$prefix.'highlight'];
$scrolling=$data[$prefix.'scrolling'];
//$headline=$data[$prefix.'headline'];


//var_dump($data);die();
if(isset($_GET['action']))
{
    $type=$_GET['action'];
    //echo $type;
    if($type==NEWS_SCROLLING)
    {
        if($scrolling)
        {
            $scrolling=0;
        }
        else{
            $scrolling=1;
        }
    }
    elseif($type==NEWS_HIGHLIGHT)
    {
        if($highlight)
        {
            $highlight=0;
        }
        else{
            $highlight=1;
        }
    }
    
    
    $db->setFieldValues('scrolling',$scrolling);
    $db->setFieldValues('highlight',$highlight);
    //$db->setFieldValues($prefix.'headline',$headline);

    $result =$db->update_core($id);
    //var_dump($result);die();
    if($result==true)
    {
        $objMsg->set('Update Successfull');
        //echo '<script>alert("Update Successfull");</script>';
        
    }
    else
    {
        $objMsg->set('Update Not Successfull');
        //echo '<script>alert("Update Not Successfull");</script>';
        
    }
    forceRedirect('?module=News&Type='.getREQUEST('Type'));
    
    
    
}

//redirect('?$module='.$_GET['module']);
?>