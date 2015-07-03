 
       <?php   include(TPL.'includes/Slider.php' );//81dc9bdb52d04dc20036dbd8313ed055?>

<div class="bodyHoliday grid_12 fontLarge ">
    <h1 class="large-title">Destinations</h1>
</div>
    <div class="container_12">
          <?php //if(isset( $arrTripCountry ) && is_array( $arrTripCountry )): ?>
             <?php while(  $dataRow= mysql_fetch_assoc($arrTripCountry)): ?> 
                            
                            
                                   <div class="grid_6 ba ">
                                     <div class="mid-child clearfix">
                                       <div class="img-container grid_5">
                                            <img width="100%" height="200px" src="uploads/trip_country/<?php echo $dataRow['trip01banner'];?>"  />
                                        </div>
                                            <div class="imgText grid_5">
                                                <span class="">
                                                    
                                                   <a class="fontExLarge" style="text-decoration: none;" href="<?php echo getSiteLink('tripcountry','','',$dataRow['trip01uin'],'',$dataRow['trip01title']);?>"> <?php echo $dataRow['trip01title'];?>
                                                   </a>
                                               
                                                </span>
                                             </div>
                                    </div>
                                    <div class="dottedLine "></div>
                                </div>
             <?php endwhile;?>
             <?php //endif; ?>
                            
               <div class="clear"></div>               
<!--2 round image------------------------->                             
                    <div class="midBody2 ">
                    
         <?php 
                while(  $dataRow1= mysql_fetch_assoc($arrActivites1)): 
                        $ActivitestUIN = $dataRow1['trip02uin'] ;
                  ?>
						<div class=" grid_4   ba" style="height: 250px;">
                      		<div class="  bodyHoliday1   alpha">
                    			<h1 class="large-title "><a class="fontLarge" style="text-decoration:none;" href="<?php echo getSiteLink('tripactivity','','',$dataRow1['trip02uin'],'',$dataRow1['trip02title']);?>"><?php echo $dataRow1['trip02title'];?></h1></a>
							</div>
                            <div class="bodyHoliday1-img-container borderRadius">
								<img src="uploads/trip_activity/<?php echo $dataRow1['trip02banner'];?>" class=""/>	
                            </div>    													
                    	</div>
        <?php 
                endwhile; 
        ?>
                        	
                                   
                            <div class="clear"></div>                         
					</div>
                    
                    
                                  
                            <div class="clear"></div>                         

<!---gallery-------------------------------------------->  
					    <div class="">
                            <div class=" grid_8   ba ">
                               
                                <div class="  bodyHoliday1  fontLarge alpha">
                                    <h1 class="large-title">Gallery</h1>
                                </div>
									<div id="wrap" class="trip-slider">
                                          <ul id="mycarousel" class="jcarousel-skin-tango">
                                            <?php 
                                                $arrGalleryPhotos=Query('select * from gal02photos');
                                                    while(  $dataRow= mysql_fetch_assoc($arrGalleryPhotos)){
                                                        
                                                        echo '<li class=""><a href="photo.php?id='.$dataRow['gal02uin'].'" title="'.$dataRow['gal02title'].'"><img src="'.'uploads/gallery_photos/photos/'.$dataRow['gal02file'].'" height="97" width="180" alt="" /></a></li>';
                                                    }
                                            ?>
                                            
                                            
                                              <a href="<?php //echo getLinks('GalleryAlbumsDetail', $dataRow['ParentInfo']);?>"> 
                                                
                                              </a> 
                                                
                                               </li> 
          <?php //endforeach;?>
             <?php //endif; ?>
                        	
                                          
                                          </ul>
                							<div class="clear"></div>
   									</div>			                                                                															
                            </div>	
                            <div class=" grid_4  ba special-tour-container">
                                <div class=" bodyHoliday1  fontLarge alpha">
                                    <h1 class="large-title">Popular Tours</h1>
                                </div>
                                <div class="tour-listing">
                                    <ul>
            <?php //if(isset( $arrpopularTrip ) && is_array( $arrpopularTrip )): ?>
            <?php $arrpopularTrip =Query('select * from trip03trips where trip03popular_tour=1'); ?>
            <?php while(  $dataRow= mysql_fetch_assoc($arrpopularTrip))://var_dump($dataRow); ?> 
             <?php //foreach( $arrpopularTrip as $dataRow): // var_dump($dataRow);?> 
                                    <li class="title-listing"> <a href="<?php echo getSiteLink('trips','','',$dataRow['trip03uin'],'',$dataRow['trip03title']);?>"><?php echo $dataRow['trip03title'];?></a></li>
          <?php endwhile;?>
             <?php //endif; ?>
                                  
                                    </ul>
                                </div>
                                                                    						
                            </div>
                            <div class="clear"></div> 
                        </div>

<!--Special------------>                        
                    <div class="midBody2 ">
						<div class=" grid_4   ba special-tour-container">
                    		<div class="  bodyHoliday2  fontLarge alpha">
                    			<h1 class="large-title">Special Interest Tours</h1>
							</div>
                                <div class="tour-listing">
                                    <ul>
           <?php $arrspecialTrip =Query('select * from trip03trips where trip03special_tour=1 '); ?>
            <?php while(  $dataRow= mysql_fetch_assoc($arrspecialTrip))://var_dump($dataRow); ?> 
              
                                     <li class="title-listing"> <a href="<?php echo getSiteLink('trips','','',$dataRow['trip03uin'],'',$dataRow['trip03title']);?>"><?php echo $dataRow['trip03title'];?></a></li>
         <?php endwhile;?>
             
                                    </ul>
                                </div>
                               
                                 
																						
                    	</div>

						<div class=" grid_4  ba special-tour-container">
                    		<div class="  bodyHoliday2  fontLarge alpha">
                    			<h1 class="large-title">Other Services</h1>
							</div>
                                <div class="tour-listing">
                                    <ul>
           <?php $arrservicesTrip =Query('select * from trip03trips where trip03other_service=1'); ?>
            <?php while(  $dataRow= mysql_fetch_assoc($arrservicesTrip))://var_dump($dataRow); ?> 
             <?php //foreach( $arrservicesTrip as $dataRow): // var_dump($dataRow);?> 
                                   <li class="title-listing"> <a href="<?php echo getSiteLink('trips','','',$dataRow['trip03uin'],'',$dataRow['trip03title']);?>"><?php echo $dataRow['trip03title'];?></a></li>
         <?php endwhile;?>
                                  
                                    </ul>
                                </div>
  																						
                    	</div>

						<div class=" grid_4   ba special-tour-container">
                    		<div class="  bodyHoliday2  fontLarge alpha">
                    			<h1 class="large-title">Best Offer</h1>
							</div>
           <?php $arrbestofferTrip =Query('select * from trip03trips where trip03bestoffer=1 limit 0,1'); ?>
            <?php while(  $dataRow= mysql_fetch_assoc($arrbestofferTrip))://var_dump($dataRow); ?> 
             <?php //foreach( $arrbestofferTrip as $dataRow):  //var_dump($dataRow);?> 
                            
                                <div class="honeymoon-img" >
								<img height="100px" src="uploads/trips/<?php if($dataRow['trip03banner1']) echo $dataRow['trip03banner1']; else echo('default.jpg'); ?>"  />
                                </div>
                                  <div class="imgText">
                                    <span class="fontMedium">
                                    <?php echo $dataRow['trip03title'];?>
                                    </span><br />
                                    <a  class="fontSmall" href="<?php echo getSiteLink('trips','','',$dataRow['trip03uin'],'',$dataRow['trip03title']);?>">
                                    read more
                                    </a>                                            
                                    </div>
         <?php endwhile;?>
             <?php //endif; ?>
                                    
                                 

                                     
																						
                    	</div>
                        
                        
                        	
                             <div class="clear"></div>                         
					
                    </div>
                    </div> 
 