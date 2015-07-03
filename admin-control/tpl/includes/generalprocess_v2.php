<?php
    //var_dump($MyModules);
    $excludeModule=array('Category','NewsType');
    if(isset($_GET["delete"]))
    {
        if($_data)
        {
            if(isset($_data[$prefix.'file']))
            {
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
            }
            
            //die();
            if($obj->delete($_GET['_Id']))
            {
                
                $message= $module_Title.' Deleted';
            }	
			else
            {
                $message= 'Cannot Delete . It might be related to some used data!!!';
            }
            
        }
        else
        {
            echo 'no data to delete';
        } 
        $cond='';
        if(isset($_GET['Type']))
        {
            $cond=$prefix.'cat01uin='.$_GET['Type'];
        }
        $data['_data']=$obj->get($cond,$_id.' desc');
        
        $data['list_fields']=array('UIN'=>$prefix.'uin','Title'=>$prefix.'title');
    }
    if(isset($_POST['sub']))
    {
        //var_dump($_POST);
        
        $fields=$fields_post;
        foreach($fields as $_field)
        {
            $f=0;
            if(isset($_POST[$_field]))
                $f=$_POST[$_field];
            $obj->setFieldValues_v2($_field,$f );
            //$field_values[$_field]=$_POST[$_field];
        }
        if(getREQUEST('action')=='edit')
        {
            
            $result='';
            $fields=$fields_edit;
            //$fields=$field_list;
            foreach($fields as $_field)
            {
                $f=0;
                if(isset($_POST[$_field]))
                {
                    $f=$_POST[$_field];
                    
                }
                    
                
                $obj->setFieldValues_v2($_field,str_replace("'", "\\'", $f));
                
            }
            
            $id = $obj->update($_POST['uin']);
    		if(isset($_FILES['file']))
            {
                //echo 'uploading file';
                $upload_result=AR_UploadImage('file',$upload_dir,array(960,960),$prefix,$_data[$prefix.'file'],'','',1);
                //var_dump($upload_result);
                if(! $upload_result[0] )
                {
                    $message =$upload_result[1];
                }
                else
                {
                    if($upload_result[1]!=$_data[$prefix.'file'])
                    {
                        $obj->setFieldValues_v2("file",$upload_result[1] );
                        $id = $obj->update($_POST['uin']);
                    }
                }
            }
        		if($id)
                {
                    //$data['_data']=$obj->getByID_v2($_POST[$_id]);
                    $message = "Update Completed Successfully";
                }
                else
                {
                    $message = "Data not Updated";
                }
                
                $_resource=$obj->getByID_v2(getREQUEST('uin'));
                $_data=$obj->Fetch($_resource);
                $data['_data']=$_data;
                //var_dump($_data);
        }
        elseif($_GET['action']=='add')
        {
            $id = $obj->insert();
    		
    		if($id>0)
            {
                if(isset($_FILES['file']))
                {
                    //echo 'uploading file';
                    $upload_result=AR_UploadImage('file',$upload_dir,array(960,960),$prefix,'','','',1);
                    //var_dump($upload_result);
                    if(! $upload_result[0] )
                    {
                        $message =$upload_result[1];
                    }
                    else
                    {
                        if($upload_result[1]!=$_data[$prefix.'file'])
                        {
                            $obj->setFieldValues_v2("file",$upload_result[1] );
                            $id = $obj->update($_POST['uin']);
                        }
                    }
                }
                $message = $module_Title." Added Successfully";
            }
            else
            {
                $message = $module_Title." Not Added !";
            }
                
                #$_resource=$obj->getByID_v2($_POST[$_id]);
                #$_data=$obj->Fetch($_resource);
        }
        
        
    }
    if(isset($_GET['action']))
    {
        if($_GET['action']=='add')
        {
            $obj->resetFieldList_v2($field_list);
            $_data=$obj->getFieldValues();
            $data['_data']=$obj->getFieldValues();
            //var_dump($_data);
        }
        //var_dump($_data);
    }
        
    
    $data['message']=$message;
    echo defaultAdminModule( $strModuleName, $data );
    ?>