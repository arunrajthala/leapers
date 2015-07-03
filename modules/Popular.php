<?php
    
    
    //$SQL='select COUNT(*) as rowCount from news02news where news02uin>0 ';
    ///$data=Query($SQL);
    
    //$page='News';
    //$objCat= new NewsType();
    $prefix='news02';
    $obj = new News();
    $list=$obj->get($prefix.'hits>0 and '.$prefix.'date between  DATE_ADD(NOW(), INTERVAL -30 DAY) AND NOW() ',$prefix.'hits desc',100,1);
    //$list=$obj->get(array('headline'=>1));
    //echo ($list->rowCount());
    //var_dump($list);
    //$Cat=$objCat->getById($id);
    $data['title']="लोकप्रिय";
    //var_dump($list);
    $data['tot_page']=ceil(($list->rowCount())/NEWS_PER_PAGE);
    //$data['data']=$list;
    //echo $list->rowCount();
    echo defaultModule( $strModuleName, $data );
?>