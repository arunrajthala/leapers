<?php
    $obj = new Programs();
    //echo date('Y-m-d');
    //echo ( $day+1).$strday;
    $list=$obj->getToday(1,4);
    $data['data']=$list;
    $data['prefix']=$obj->getPrefix();
    //var_dump($data);
    echo defaultModule( $strModuleName, $data );
?>