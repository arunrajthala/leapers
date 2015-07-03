<?php
    
    //var_dump($MyModules);
    
    $objMsg=new Message();
    $prefix=$obj->getPrefix();
    if($id)
	   $_data = $obj->getByID($id);
    //var_dump($obj);die();
    $data['list_fields']=$obj->getListField();
    if(isset($_GET["delete"]))
    {
        if($_data)
        {
            
            
            //die();
            if($obj->delete($_GET['_Id']))
            {
                
                $objMsg->set( $module_Title.' Deleted');
            }	
			else
            {
                $objMsg->set('Cannot Delete . It might be related to some used data!!!',1);
            }
            
        }
        else
        {
            $objMsg->set( 'no data to delete');
        } 
        $cond='';
        if(isset($_GET['Type']))
        {
            $cond=$prefix.$prefix1.'uin='.$_GET['Type'];
        }
        $data['_data']=$obj->get($cond,$obj->getPrefix().'uin desc');
        
        $data['list_fields']=$obj->getListField();
        $exArr=array('delete','_Id');
        $strqry='';
        foreach($_GET as $k=>$gets)
        {
            
            if(!in_array($k,$exArr))
                $strqry.= '&'.$k.'='.$gets;
        }
        //die();
        forceRedirect('home.php?'.$strqry);
        
    }
    if(isset($_GET["order"]))
    {
        $order=$_GET['order'];
        if($_data)
        {
            
            
            //die();
            if($obj->ArrangeOrder($_GET['_Id'],$order))
            {
                
                $objMsg->set( $data['module_Title'].' Ordered');
            }	
			else
            {
                $objMsg->set('Oops! something went wrong!!!',1);
            }
            
        }
        else
        {
            $objMsg->set( 'no data to sort');
        } 
        $cond='';
        if(isset($_GET['Type']))
        {
            $cond=$prefix.$prefix1.'uin='.$_GET['Type'];
        }
        $data['_data']=$obj->get($cond,$obj->getPrefix().'uin desc');
        
        $data['list_fields']=$obj->getListField();
        $exArr=array('delete','_Id','order');
        $strqry='';
        foreach($_GET as $k=>$gets)
        {
            
            if(!in_array($k,$exArr))
                $strqry.= '&'.$k.'='.$gets;
        }
        forceRedirect('home.php?'.$strqry);
        
    }
    if(getREQUEST('deletefile'))
    {
        //echo ' i am in delete file ';
        if(getREQUEST('deletefile')=='1')
        {
            if(isset($_GET['field']))
            {
                $field=$_GET['field'];
                if($_data[$prefix.$field]!='')
                {
                    //echo 'deleteing file';
                    if(file_exists($upload_dir.$_data[$prefix.$field]))
                    {
                        if( !unlink($upload_dir.$_data[$prefix.$field]))
                                die('Cannot delete file');
                        else
                        {
                            
                            if(file_exists($upload_dir.'thumb/'.$_data[$prefix.$field]))
                            {
                                if( !unlink($upload_dir.'thumb/'.$_data[$prefix.$field]))
                                die('Cannot delete thumb');
                            }
                            
                        }
                    }
                    $obj->setFieldValues($field,'');
                    //var_dump($obj->getFieldValues());
                    $obj->update_core($id);
                    $objMsg->set('File deleted');
                    $data['_data']=$obj->getByID($id);
                    $strqry='';
                    //die();
                    //forceRedirect('home.php?module=News&action=edit&_Id='.getREQUEST('_Id'));
                    //$data['list_fields']=array('UIN'=>$prefix.'uin','Title'=>$prefix.'title');
                }
            }
            elseif($_data[$prefix.'file']!='')
            {
                //echo 'deleteing file';
                if(file_exists($upload_dir.$_data[$prefix.'file']))
                {
                    if( !unlink($upload_dir.$_data[$prefix.'file']))
                            die('Cannot delete file');
                    else
                    {
                        
                        if(file_exists($upload_dir.'thumb/'.$_data[$prefix.'file']))
                        {
                            if( !unlink($upload_dir.'thumb/'.$_data[$prefix.'file']))
                            die('Cannot delete thumb');
                        }
                        
                    }
                }
                $obj->setFieldValues('file','');
                //var_dump($obj->getFieldValues());
                $obj->update_core($id);
                $objMsg->set('File deleted');
                $data['_data']=$obj->getByID($id);
                $strqry='';
                //die();
                //forceRedirect('home.php?module=News&action=edit&_Id='.getREQUEST('_Id'));
                //$data['list_fields']=array('UIN'=>$prefix.'uin','Title'=>$prefix.'title');
            }
        }
        $exArr=array('delete','deletefile');
        foreach($_GET as $k=>$gets)
        {
            
            if(!in_array($k,$exArr))
                $strqry.= '&'.$k.'='.$gets;
        }
            forceRedirect('home.php?'.$strqry);
    }
    if(isset($_POST['sub']))
    {
        //var_dump($_POST);
        
        
        if(getREQUEST('action')=='edit')
        {
            
            $result='';
            //var_dump($_POST);
            //echo 'hellw';
            //var_dump($_POST);
            $id = $obj->update($_POST['uin'],$_POST);
            //echo 'hellw';
            //var_dump($id);die();
        		if($id)
                {
                    //$data['_data']=$obj->getByID($_POST[$_id]);
                    $objMsg->set("Update Completed Successfully");
                }
                else
                {
                    $objMsg->set("Data not Updated",1);die();
                }
                
                $_resource=$obj->getByID(getREQUEST('uin'));
                $_data=$obj->Fetch($_resource);
                $data['_data']=$_data;
                //var_dump($_data);
                
        }
        elseif($_GET['action']=='add')
        {
            
            $id = $obj->insert($_POST);
    		
    		if($id>0)
            {
                
                $objMsg->set("Posts for ". $data['module_Title']." Added Successfully");
            }
            else
            {
                $objMsg->set("Posts for ".$data['module_Title']." Not Added !",1);
            }
                
                #$_resource=$obj->getByID($_POST[$_id]);
                #$_data=$obj->Fetch($_resource);
        }
        $strqry='';
        foreach($_GET as $k=>$gets)
        {
            //echo $gets;
            if($k !='deletefile')
                $strqry.=$k.'='.$gets.'&';
        }
            //echo $strqry;die();
        forceRedirect('home.php?'.$strqry);
        
    }
    if(isset($_GET['action']))
    {
        if($_GET['action']=='add')
        {
            $obj->resetFieldList($field_list);
            $_data=$obj->getFieldValues();
            $data['_data']=$obj->getFieldValues();
            //var_dump($_data);
        }
        //var_dump($_data);
    }
    $showList=true;
    if(isset($_POST['sub']) || getREQUEST('deletefile')|| getREQUEST('delete'))
    {
        $showList=false;
    }
    
    //echo 'hellw';
    //$data['message']=$message;
    if($showList)
    {
        echo LoadDefaultAdminModule_v2( $strModuleName, $data );
    }
    
    ?>