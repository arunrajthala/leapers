<?php
    
    function getHighlights($module)
    {
        $objType = new NewsType();
        $prefix=$objType->getPrefix();//'news02';
        $cat_datas =$objType->getByModuleName($module);
        if(empty($cat_data))
        {
            return false;
        }
        //var_dump($cat_datas);
        $cat_data='';
        $id=0;
        //echo $module;
        foreach($cat_datas as $row)
        {
            $id=$row['news01uin'];
            $cat_data=$row;
        }
        $objNews=new News();
        $data=$objNews->getByType($id,1,5);
        
    ?>
       
       <div class="col-md-4 col-xs-4 col-sm-4">
                    <article class="NSNewsWrapper Similar-Box">
                      <header>
                        <h3 class="pull-left"><?php echo $cat_data['news01'.'title']; ?></h3>
                        <a href="<?php echo getSiteLink('News','','',$cat_data['news01'.'uin'],$cat_data['news01'.'title']); ?>" class="pull-right">View All</a>
                        
                        <div class="clearfix"></div>
                    </header>
                    <section>
                    <?php $list='';?>
                        <?php $ct=0; foreach($data as $row): ?>
                            <?php if($ct<2): ?>
            					<ul class="MNList">
                                    
            						<li>
            							<a href="<?php echo getSiteLink('NewsArticle','',$row[$objNews->getPrefix().'title'],$row[$objNews->getPrefix().'uin'])?>"><?php echo $row['news02title'] ?></a>
            							<img src="uploads/news/<?php echo $row['news02file'] ?>" alt=""/>
            							<p>
            								<?php $shortTry=substr($row['news02shortDesc'],0,450); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
            							</p>
            							<div class="clearfix">
            							</div>
            						</li>
            						
            					</ul>
                            <?php 
                                else: 
        					       $list.='<li><a href="'.getSiteLink('NewsArticle','',$row['news02title'],$row['news02uin']).'">'. $row['news02title'] .'</a></li>';
                             endif;?>
                    <?php $ct++;endforeach;?>
                            <ul class="RNList">
        						<?php echo $list;?>
        					</ul>
				</article>
    </div>
                        
<?php
    }
    function getSingleBlockByType($module)
    {
        $objType = new NewsType();
        
        $cat_data =$objType->getByModuleName($module);
        //var_dump($cat_datas);
        //$cat_data='';
        $id=$cat_data['news01uin'];
        
        $objNews=new News();
        $prefix=$objNews->getPrefix();//'news02';   
        $data=$objNews->getByType($id,1,5);
        $uploadUrl=UPLOADS.$objNews->getUploadURL().'thumb/';
        //var_dump($data);
        
    ?>
                <div class="col-md-4">
					<div class="internal-news">
						<h2>
                            <a href="<?php echo getSiteLink('News','','',$cat_data['news01'.'uin'],$cat_data['news01'.'title']); ?>"><?php echo $cat_data['news01'.'title']; ?></a>
                        
                        </h2>
					</div>
					<div class="news-blog">
						
						<div class="media">
                            <?php $list='';$list2='';?>
                            <?php $ct=0; foreach($data as $row): ?>
                                <?php if($ct<1): ?>
                                    <h3>
                                        <a href="<?php echo getSiteLink('News','','',$cat_data['news01'.'uin'],$cat_data['news01'.'title']); ?>">
                                        <?php echo $row['news02title'] ?>
                                        </a>
                                    </h3>
        							<div class="media-left"> 
                                    <?php echo LoadMyImage($uploadUrl,$row[$prefix.'file'],$row[$prefix.'title']) ?>
                                     
                                    </div>
        							<div class="media-body"> <a href="#"></a>
        								<p>
                                            <?php echo clipMyText($row[$prefix.'detail'],200); ?>
                                        </p>
        							</div>
                                <?php else:
                                $list2.='<li><a href="'.getSiteLink('NewsArticle','',$row[$objNews->getPrefix().'title'],$row[$objNews->getPrefix().'uin']).'">'.$row['news02title'].'</a></li>';
                                endif;?>
                            <?php $ct++; endforeach;?>
							<div class="news-item-blog">
								<ul>
								    <?php echo $list2;?>									
                                </ul>
							</div>
						</div>
					</div>
				</div>             
<?php
    }
    function getSideBlock($module)
    {
        $objType = new NewsType();
        $cat_datas =$objType->getByModuleName($module);
        $cat_data='';
        foreach($cat_datas as $row)
        {
            $id=$row['news01uin'];
            $cat_data=$row;
        }
        $objNews=new News();
        $data=$objNews->getByType($id,1,6);
        //$data1=$objNews->getByType($id,2,3);
        $prefix='news02';
?>
        <section class="col-md-4 col-sm-5 col-xs-12 news-box right news">
            <header class="heading">
            <a href="<?php echo getSiteLink('News','','',$cat_data['news01'.'uin'],$cat_data['news01'.'title']); ?>" class="more">बाँकी अंश</a>
                <h2><?php echo $cat_data['news01'.'title']; ?></h2>
            </header>
            <div class="content-holder">
                <?php $lists='';?>
                <?php $ct=0; foreach($data as $row): ?>
                    <?php if($ct<3): ?>
                <article class="photo-news">
                    <h3><a href="<?php echo getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin'])?>"><?php echo $row['news02title'] ?></a></h3>
                    <img src="uploads/news/<?php echo $row['news02file'] ?>" alt="entertainment">
            						<div class="news-content">
            						  <p><?php $shortTry=substr($row['news02shortDesc'],0,400); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
            						</div>
            					</article>
                    <?php else: ?>
               
                        <?php $lists.='<li><a href="'.getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin']).'">'. $row['news02title'] .'</a></li>';?>
                        
                
                    <?php endif;?>
                    <?php $ct++;endforeach ?>
                    <?php echo '<ul>'.$lists.'</ul>'; ?>
            </div>
        </section>
<?php        
    }
    function getSideBlock_2_3($module)
    {
        $objType = new NewsType();
        $cat_datas =$objType->getByModuleName($module);
        $cat_data='';
        foreach($cat_datas as $row)
        {
            $id=$row['news01uin'];
            $cat_data=$row;
        }
        $objNews=new News();
        $data=$objNews->getByType($id,1,5);
        //$data1=$objNews->getByType($id,2,3);
        $prefix='news02';
?>
        <section class="col-md-4 col-sm-5 col-xs-12 news-box right news">
                            <header class="heading">
                            <a href="<?php echo getSiteLink('News','','',$cat_data['news01'.'uin'],$cat_data['news01'.'title']); ?>" class="more">बाँकी अंश</a>
                                <h2><?php echo $cat_data['news01'.'title']; ?></h2>
                            </header>
                            <div class="content-holder">
                                <?php $lists='';?>
                                <?php $ct=0; foreach($data as $row): ?>
                                    <?php if($ct<2): ?>
                                <article class="photo-news">
                                    <h3><a href="<?php echo getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin'])?>"><?php echo $row['news02title'] ?></a></h3>
                                    <img src="uploads/news/<?php echo $row['news02file'] ?>" alt="entertainment">
                            						<div class="news-content">
                            						  <p><?php $shortTry=substr($row['news02shortDesc'],0,400); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
                            						</div>
                            					</article>
                                    <?php else: ?>
                               
                                        <?php $lists.='<li><a href="'.getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin']).'">'. $row['news02title'] .'</a></li>';?>
                                        
                                
                                    <?php endif;?>
                                    <?php $ct++;endforeach ?>
                                    <?php echo '<ul>'.$lists.'</ul>'; ?>
                            </div>
                        </section>
<?php        
    }
    function getSingleBlockByType2($module,$noClass=0)
    {
        $objType = new NewsType();
        $cat_datas =$objType->getByModuleName($module);
        $cat_data='';
        foreach($cat_datas as $row)
        {
            $id=$row['news01uin'];
            $cat_data=$row;
        }
        $objNews=new News();
        $data=$objNews->getByType($id,1,3);
        $data1=$objNews->getByType($id,2,3);
        $prefix='news02';
        $class='col-md-8 news-box add news';
        if($noClass)
        {
            $class='';
        }
    ?>
        <section class="<?php echo $class;?>">
                        	<header class="heading">
                            <a href="<?php echo getSiteLink('News','','',$cat_data['news01'.'uin'],$cat_data['news01'.'title']); ?>" class="more">बाँकी अंश</a>
                                <h2><?php echo $cat_data['news01'.'title']; ?></h2>
                            </header>
                            
                            <div class="row inside">
                                <?php $lists='';?>
                                <?php $ct=0; foreach($data as $row): ?>
                                    <?php if($ct<1): ?>
                            			<div class="col-md-6 col-sm-6 inside full-banner">
                            				<div class="content-holder">
                            					<h3><a href="<?php echo getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin'])?>">
                                                <?php $shortTry=substr($row['news02title'],0,200); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
                                                </a></h3>  
                            					<article class="main-news">
                            						<img src="uploads/news/<?php echo $row['news02file'] ?>" alt="entertainment">
                            						<div class="news-content">
                                                        
                                                        <p><?php $shortTry=substr($row['news02detail'],0,1330); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
                            						  
                            						</div>
                            					</article>
                            				</div>
                            			</div>
                                    <?php else: ?>
                                			<div class="col-md-6 col-sm-6 inside">
                                				<div class="content-holder">
                                                    <?php if($ct<3): ?>
                                					<article class="photo-news">
                                						<h3>
                                							<h3><a href="<?php echo getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin'])?>">
                                                            <?php $shortTry=substr($row['news02title'],0,200); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
                                                            </a></h3>
                                						</h3>
                                						<img src="uploads/news/<?php echo $row['news02file'] ?>" alt="img2">
                                						<div class="news-content">
                                                        <p><?php $shortTry=substr($row['news02shortDesc'],0,450); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
                                						</p>
                                                        </div>
                                					</article>
                                					<?php endif;?>
                                                    <?php if($ct==2): ?>
                                                    <ul>
                                                    <?php foreach ($data1 as $row):?>
                                                            <?php $lists.='<li><a href="'.getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin']).'">'. $row['news02title'] .'</a></li>';?>
                                                    <?php endforeach;?>
                                                        <?php echo $lists; ?>
                                                    </ul>
                                					<?php endif;?>
                                                    
                                				</div>
                                			</div>
                                    <?php endif;?>
                                    
                                <?php $ct++;endforeach ?>
                                
                    		</div>
                            
                                        
                            
                                
                                   
                            
                        </section>
<?php
    }
    function getSubModule($module)
    {
        if(substr($module,0,strlen('adversitse'))=='adversitse')
        {
            include_once(TPL.'includes/ad'.substr($module,-1).'.php');
            return;
        }
        elseif($module=='frompaper')
        {
            include_once(TPL.'includes/from_paper.php');
            return;
            
        }
         $objType = new NewsType();
        $cat_datas =$objType->getByModuleName($module);
        if($cat_datas->rowCount()<1)
        {
            return;
        }
        $cat_data='';
        $id=0;
        foreach($cat_datas as $row)
        {
            $id=$row['news01uin'];
            $cat_data=$row;
        }
        $objNews=new News();
        $data=$objNews->getByType($id,1,5);
        //$data1=$objNews->getByType($id,2,5);
        $prefix='news02';
?>
        <header class="heading">
                	<a href="<?php echo getSiteLink('News','','',$cat_data['news01'.'uin'],$cat_data['news01'.'title']); ?>" class="more">बाँकी अंश</a>
                    <h2><?php echo $cat_data['news01'.'title']; ?></h2>
                </header>
                </header>
                <div class="content-holder">
                    <?php $lists='';?>
                            <?php $ct=0; foreach($data as $row): ?>
                                <?php if($ct<2): ?>
                                    <article class="photo-news">
                                        <img src="uploads/news/<?php echo $row['news02file'] ?>" alt="img1">
                                            <h3><a href="<?php echo getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin'])?>"><?php echo $row['news02title'] ?></a></h3>
                                            <p><?php $shortTry=substr($row['news02shortDesc'],0,300); echo substr($shortTry,0,strrpos($shortTry, ' ', -1)); ?>
                                    </article>
                                    
                                <?php else: ?>
                                    <?php $lists.='<li><a href="'.getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin']).'">'. $row['news02title'] .'</a></li>';?>
                                   
                                <?php endif;?>
                                    
                            <?php $ct++;endforeach ?>
                            <?php echo '<ul>'.$lists.'</ul>'; ?>
                </div>
<?php                            
    }
    
?>