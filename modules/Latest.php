<?php
    
    
    //$SQL='select COUNT(*) as rowCount from news02news where news02uin>0 ';
    ///$data=Query($SQL);
    
    //$page='News';
    //$objCat= new NewsType();
    $obj = new News();
    $list=$obj->get();
    //echo ($list->rowCount());
    //var_dump($list);
    //$Cat=$objCat->getById($id);
    $data['title']="ताजा खबर";
    $data['data']=$list;
    $data['tot_page']=ceil(($list->rowCount())/NEWS_PER_PAGE);
    //echo $list->rowCount();
    echo defaultModule( $strModuleName, $data );
?>