<?php
    //Its a sample Module
    //Here are autodefined varaibles like: $strModuleName, $arrSharedData
    //If you want to pass the values to template then populate it to $arrSharedData
    //Either you can populate it manually or use + like: $arrSharedData = compact('xyz','abc') + $arrSharedData
    //$arrSharedData['content'] = 'this is EPC module';
    $ct=0;
    //echo 'hellow this is slider';
    echo defaultModule( $strModuleName, $arrSharedData);
?>