<?php
    //var_dump( get_browser());
    $id=getREQUEST('_Id');
    if(! $id)
    {
        $url=getSiteLink('home');
        //echo $url;
        forceRedirect($url);
    }
    $objCat= new NewsType();
    $obj = new News();
    $objHitCounter= new HitCounter();
    $ip=$_SERVER['REMOTE_ADDR'];
    $list=$obj->getById($id);
    if($objHitCounter->CheckHitsByIpPost($ip,$id))
    {
        //echo 'voila';
        $objHitCounter->insert(array('news02uin'=>$id,'ip_add'=>$ip,'agent'=>$_SERVER['HTTP_USER_AGENT']));
        //echo $id;
        $totHits=$list['news02hits'];
        $totHits++;
        $obj->setFieldValues('hits',$totHits);
        $obj->update_core($id);
            
        
    }
    
    
    //$page='News';
    
    
    //echo ($list->rowCount());
    //var_dump($list);
    $Cat=$objCat->getById($list['news02news01uin']);
    $data['title']=$Cat['news01title'];
    $data['catid']=$Cat['news01uin'];
    $data['data']=$list;
    echo defaultModule( $strModuleName, $data );
?>