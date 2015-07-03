<?php

    function BuildMenu($parentId,$ParentName='')
   {
        //$menu='';
        $ObjMenu=new NewsType();
        $MenuPrefix=$ObjMenu->getPrefix();
        $_result= $ObjMenu->get(array('parent'=>$parentId,'menu'=>0));
        //var_dump($_result);
		$_class='';
        if(count($_result)<1)
        {
            return ;
        }
        else
        {
            //var_dump(count($_result));
        }
         $ulclass='"" ';
         $exAttr='';
        if($parentId<1)
        {
            $ulclass='nav navbar-nav';
        }
        else
        {
            $ulclass='dropdown-menu';
            $exAttr='role="menu"';
            
        }
        //
		echo '<ul class="'.$ulclass.'" '.$exAttr.'>';
		foreach ($_result as $menuItem)
		{
		  //var_dump($menuItem);
	      $class='';
            
            if(isset($_GET['page']))
            {
                
                $curr_module=substr($_GET['page'],0,strlen($menuItem[$MenuPrefix.'module']));
                //echo $curr_module.$menuItem[$MenuPrefix.'module'];
            }
            else
            {
                $curr_module='home';
            }
            if(strtolower($curr_module)==strtolower($menuItem[$MenuPrefix.'module'])) $class= 'active';
            if($class!='')
            {
                //echo $curr_module;
            }
            //echo $class;
			//var_dump($_row);
            $url='';
            if($menuItem[$MenuPrefix.'url']=="0" ||$menuItem[$MenuPrefix.'url']=='')
            {
                $url='';
            }
            elseif($menuItem[$MenuPrefix.'hasChild']=='0')
            {
                $url=$menuItem[$MenuPrefix.'module'];
            }
            elseif($menuItem[$MenuPrefix.'url']==1)
            {
                $url='ActivityList';
            }
            elseif( $menuItem[$MenuPrefix.'url'])
            {
                $url=$menuItem[$MenuPrefix.'url'];
            }
            //echo $url;
            //if($menuItem[$MenuPrefix.'url']!=-1)
            {
                $exAttr='';
                if($menuItem[$MenuPrefix.'hasChild'])
                {
                    $class.=' dropdown';
                    $exAttr='class = "dropdown-toggle" data-toggle="dropdown"';
                    }
                //if($parentId>0)
                    
                echo '<li class="'.$class.'" >';
                echo'<a '.$exAttr.' href="';
                //if($parentId==0)
                {
                    if($url=='ActivityList')
                    {
                        echo getSiteLink($url,'','',$menuItem[$MenuPrefix.'uin'],$menuItem[$MenuPrefix.'title']);
                    }
                    else
                    {
                        echo getSiteLink($url,'');
                        //echo getSiteLink($url,'',$menuItem[$MenuPrefix,'uin'],$menuItem[$MenuPrefix.'title']);
                    }
                    
                }
                
                
                echo '" title="'.$menuItem[$MenuPrefix.'title'.$_SESSION['lang_type']].'">';
                if($menuItem[$MenuPrefix.'module']=='home')
                {
                    echo '<span class="fa fa-home fa-fw"></span>';
                }
                else
                {
                    echo $menuItem[$MenuPrefix.'title'.$_SESSION['lang_type']];   
                    if($menuItem[$MenuPrefix.'hasChild']==1)
                    {
                        echo '<span class="caret"></span>';
                    } 
                }
                
                echo       '</a>';
                //$objSub= new NewsType();
                if($menuItem[$MenuPrefix.'hasChild'])
                {
                    $datasubMenu= $ObjMenu->getByParent($menuItem[$MenuPrefix.'uin']);
                
                    if(count($datasubMenu)>0) 
                    {
                        //echo $menuItem[$MenuPrefix.'uin'].' '.$menuItem[$MenuPrefix.'module'];
                        BuildMenu($menuItem[$MenuPrefix.'uin'],$menuItem[$MenuPrefix.'module']);
                    }
                }
                    
                
                    
                echo     '</li>';	
            }
            
		}
        echo '</ul>';
        //return $menu;
   }

    

    $objNews= new News();
    $scrolling=$objNews->get(array('scrolling'=>1),'',5,1); 
    
    /*include_once(ADMIN_MODULE.'modules/nepali_calendar.php');
    $myCalendar= new Nepali_Calendar();
    $date = date('d-m-Y');
    $d=explode('-',$date);
    $cdate=$myCalendar->eng_to_nep($d[2],$d[1],$d[0]);
    $nepaliDate=$cdate['day'].' '.$cdate['nmonth'].' '.$cdate['date'].' , '.$cdate['year'];
    $date=date('l jS F Y');*/
                       
    $data['prefix']='news02';
    //$data['NepaliDate']=$nepaliDate;
    $data['scrolling_data']=$scrolling;
    
   echo defaultModule( $strModuleName, $data);
?>