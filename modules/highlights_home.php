<?php
    
    
    //$SQL='select COUNT(*) as rowCount from news02news where news02uin>0 ';
    ///$data=Query($SQL);
    
    //$page='News';
    //$objCat= new NewsType();
    $obj = new NewsType();
    $objNews = new News();
    $activity_type=$obj->getByModuleName('activity');
    //var_dump($activity_type);
    $activity=$objNews->getByType($activity_type['news01uin'],1,1);
    //var_dump($activity);
    $plan=$obj->getByModuleName('plans');
    $donation =$obj->getByModuleName('donation');
    //var_dump($donation);
    //var_dump($activity);
    if(! empty($activity))
        $list['activity']=clipMyText($activity[0]['news02detail'],500);
    else
        $list['activity']='';
    $list['plan']=clipMyText($plan['news01detail'],500);
    $list['donation']=clipMyText($donation['news01detail'],200);
    //echo ($list->rowCount());
    //var_dump($list);
    //$Cat=$objCat->getById($id);
    $data['title']="ताजा खबर";
    $data['data']=$list;
    //var_dump($data);
    //$data['tot_page']=ceil(($list->rowCount())/NEWS_PER_PAGE);
    //echo $list->rowCount();
    echo defaultModule( $strModuleName, $data );
?>