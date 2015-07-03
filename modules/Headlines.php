<?php
    //var_dump( get_browser());
    $id=24;
    

    //$id=getREQUEST('_Id');
    
    $objCat= new NewsType();
    $obj = new News();
    
        $list=$obj->get(array('highlight'=>1));
        $data['title']='प्रमुख समाचार';
    
    $data['id']=$id;
    
    $data['data']=$list;
    $data['tot_page']=ceil(count($list)/NEWS_PER_PAGE);
    //var_dump($data);
    //echo $list->rowCount();
    if(isset($strModuleName))
    {
        echo defaultModule( $strModuleName, $data );
    }
?>
    
