<?php
    $obj = new Partner();
    $list=$obj->get();
    //$data['title']="????????";
    $data['data']=$list;
    $data['prefix']=$obj->getPrefix();
    $data['uploadUrl']=BASE_URL.'uploads/'.$obj->getUploadURL();
    echo defaultModule( $strModuleName, $data );
?>