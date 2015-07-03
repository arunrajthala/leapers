<?php
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
            $obj->setFieldValues($_field,$f );
            //$field_values[$_field]=$_POST[$_field];
        }
        if($_GET['action']=='edit')
        {
            
            $result='';
            $fields=$fields_edit;
            //$fields=$field_list;
            foreach($fields as $_field)
            {
                $f=0;
                if(isset($_POST[$_field]))
                    $f=$_POST[$_field];
                
                $obj->setFieldValues($_field,str_replace("'", "\\'", $f));
                
            }
            
            $id = $obj->update($_POST[$_id]);
    		if(isset($_FILES['file']))
            {
                //echo 'uploading file';
                $upload_result=AR_UploadImage('file',$upload_dir,array(960,960),$prefix,$_data[$prefix.'file']);
                if(! $upload_result[0] )
                {
                    $message =$upload_result[1];
                }
                else
                {
                    if($upload_result[1]!=$_data[$prefix.'file'])
                    {
                        $obj->setFieldValues($prefix."file",$upload_result[1] );
                        $id = $obj->update($_POST[$_id]);
                    }
                }
            }
        		if($id)
                {
                    $data['_data']=$obj->getByID($_POST[$_id]);
                    $message = "Update Completed Successfully";
                }
                else
                {
                    $message = "Date not Updated";
                }
                
                $_resource=$obj->getByID($_POST[$_id]);
                $_data=$obj->Fetch($_resource);
        }
        elseif($_GET['action']=='add')
        {
            $id = $obj->insert();
    		
    		if($id>0)
            {
                if(isset($_FILES[$prefix.'file']))
                {
                    //echo 'uploading file';
                    $upload_result=AR_UploadImage('file',$upload_dir,array(960,960),$prefix,$_data[$prefix.'file']);
                    if(! $upload_result[0] )
                    {
                        $message =$upload_result[1];
                    }
                    else
                    {
                        if($upload_result[1]!=$_data[$prefix.'file'])
                        {
                            $obj->setFieldValues($prefix."file",$upload_result[1] );
                            $id = $obj->update($id);
                        }
                    }
                }
                $message = $module_Title." Added Successfully";
            }
            else
            {
                $message = $module_Title." Not Added !";
            }
                
                #$_resource=$obj->getByID($_POST[$_id]);
                #$_data=$obj->Fetch($_resource);
        }
        
        
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
        
    
    $data['message']=$message;
    echo defaultAdminModule( $strModuleName, $data );
    ?>