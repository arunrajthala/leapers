<?php
    
    //$objCat= new FromPaper();
    $obj = new FromPaper();
    $list=$obj->get();
    //echo ($list->rowCount());
    //var_dump($list);
    //$Cat=$objCat->getById($id);
    $data['title']='पत्रपत्रिका बाट';
    $data['data']=$list;
    $data['tot_page']=ceil(($list->rowCount())/NEWS_PER_PAGE);
    //echo $list->rowCount();
    echo defaultModule( $strModuleName, $data );
?>