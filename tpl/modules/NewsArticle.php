<meta property="og:image" content="<?php echo BASE_URL.'/uploads/news/'.$data['news02file']; ?>"/>
<meta property="og:title" content="<?php echo $data['news02title']; ?>"/>
<meta property="og:detail" content="<?php echo clipMyText( $data['news02detail'],500); ?>"/>

<div class="internal-news">
      <h2><?php echo $data['news02title']; ?></h2>
</div>
<div class="social-sharing">
               	<script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "9873e8fe-4151-4e35-9577-0646980dbb39", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
        <span class='st_sharethis' displayText='ShareThis'></span>
        <span class='st_googleplus' displayText='Google +'></span>
        <span class='st_facebook' displayText='Facebook'></span>
        <span class='st_twitter' displayText='Tweet'></span>
        <span class='st_linkedin' displayText='LinkedIn'></span>
        <span class='st_pinterest' displayText='Pinterest'></span>
        <span class='st_email' displayText='Email'></span>
    
        <span class='st_fblike' displayText='Facebook Like'></span>
    </div>
<div class="about-us">
    <a  rel="lightbox[gallery1]" href="<?php echo BASE_URL.'/uploads/news/'.$data['news02file'] ?>" title="<?php echo $data['news02title'];?>">
   <?php echo  LoadMyImage(BASE_URL.'/uploads/news/',$data['news02file'],$data['news02title'],'') ?>
    
    </a>
    
    
    <p><?php echo $data['news02detail']; ?></p>            	
</div>

    
    
    




