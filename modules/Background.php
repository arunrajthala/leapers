<?php
    $objSetting= new Setting(); 
    $setting=$objSetting->getByID(1);
    $data['background']=$setting['set01about'];
    $data['title']='पृष्ठभूमि';
    echo defaultModule( $strModuleName, $data );
?>