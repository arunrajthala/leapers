<?php
    
    
    //$SQL='select COUNT(*) as rowCount from news02news where news02uin>0 ';
    ///$data=Query($SQL);
    
    //$page='News';
    //$objCat= new NewsType();
    $obj = new News();
    $list=$obj->get(array('highlight'=>1),'',1000,1);
    //$list=$obj->get(array('headline'=>1));
    //echo ($list->rowCount());
    //var_dump($list);
    //$Cat=$objCat->getById($id);
    $data['title']="प्रमुख समाचार ";
    //var_dump($list);
    $data['tot_page']=ceil(($list->rowCount())/NEWS_PER_PAGE);
    //$data['data']=$list;
    //echo $list->rowCount();
    echo defaultModule( $strModuleName, $data );
?>