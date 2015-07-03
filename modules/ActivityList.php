
<?php
    $id=getREQUEST('_Id');
    
    $objCat= new NewsType();
    $obj = new News();
    if($id)
    {
        $list=$obj->getByType($id);
        $Cat=$objCat->getById($id);
        $data['title']=$Cat[$objCat->getPrefix().'title'];//News & Events';
    }
    else
    {
        forceRedirect(BASE_URL);die();
        $list=$obj->get();
        $data['title']='News & Events';
    }
    
    
    $data['data']=$list;
    $data['tot_page']=ceil(count($list)/NEWS_PER_PAGE);
    //var_dump($data);
    //echo $list->rowCount();
    echo defaultModule( $strModuleName, $data );
?>