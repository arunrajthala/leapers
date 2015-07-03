
<?php
    
    $obj = new GalleryAlbums();
    $ct=0;
    $prefix1=$obj->getPrefix();
    $uploadUrl= $obj->getUploadURL();
    $_data=$obj->get();
    $data['data']=$_data;
    $data['prefix']=$prefix1;
    $data['uploadUrl']=$obj->getUploadURL();
    echo defaultModule( $strModuleName, $data );
?>