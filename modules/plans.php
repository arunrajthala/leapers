<?php
    
    //$page='News';
    $objCat= new NewsType();
    
    
    $Cat=$objCat->getByModuleName('plans');
    //var_dump($Cat);
    $data=array();
    $data['title']=$Cat['news01title'];
        $data['data']=$Cat;
    
    echo defaultModule( $strModuleName, $data );
?>