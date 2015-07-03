<?php
    //var_dump( get_browser());
    $id=getREQUEST('_Id');
    if(! $id)
    {
        $url=getSiteLink('home');
        //echo $url;
        forceRedirect($url);
    }
    //$objCat= new NewsType();
    $obj = new FromPaper();
    //$objHitCounter= new HitCounter();
    //$ip=$_SERVER['REMOTE_ADDR'];
    $list=$obj->getById($id);
    
    $data['title']='पत्रपत्रिका बाट';
    $data['data']=$list;
    echo defaultModule( $strModuleName, $data );
?>