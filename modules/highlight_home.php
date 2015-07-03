<?php
    
    
    //$SQL='select COUNT(*) as rowCount from news02news where news02uin>0 ';
    ///$data=Query($SQL);
    
    //$page='News';
    //$objCat= new NewsType();
    
    $objNews = new News();
    $data['_data']=$objNews->getHighlights(8);
    //var_dump($data);
    echo defaultModule( $strModuleName, $data );
?>