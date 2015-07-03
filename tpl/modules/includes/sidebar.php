<aside id="sidebar" class="col-md-3">
    <?php
        $objAd= new Advertisement();
        $ad_side=$objAd->getByType(AD_INNER);
        
        //var_dump($ad1);
    ?>
    <?php foreach ($ad_side as $row): ?>
    	<div class="advertise">
        	<a href="<?php echo $row['cat02url'] ?>" target="_blank">
                              	 <img src="uploads/Ad/<?php echo $row['cat02file'] ?>" alt="Contact us for ad">
                                </a>
        </div>
    <?php endforeach; ?>
    
</aside>