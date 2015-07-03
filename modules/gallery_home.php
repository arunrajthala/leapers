<?php
    
    
    //$SQL='select COUNT(*) as rowCount from news02news where news02uin>0 ';
    ///$data=Query($SQL);
    
    //$page='News';
    //$objCat= new NewsType();
    
    $objAlbums = new GalleryAlbums();
    $data['_data']=$objAlbums->get('','',6);
    $data['prefix']=$objAlbums->getPrefix();
    $data['upload_url']=UPLOADS.$objAlbums->getUploadURL();
    echo defaultModule( $strModuleName, $data );
?>