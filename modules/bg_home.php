<?php
    $objSetting= new Option(); 
    $setting=$objSetting->getByID(1);
    //var_dump($setting);
    $data['background']=$setting['set01about'];
    echo defaultModule( $strModuleName, $data );
?>