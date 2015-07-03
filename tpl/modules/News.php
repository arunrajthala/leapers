<?php
    $per=NEWS_PER_PAGE;
    $start_page=1;
    
?>
<div class="internal-news">
    <h2><?php echo $title ?></h2>
  </div>
                <ul class="pagination"></ul>
           		<div class="content-holder" id="newsList">
                
                
            </div>
           <ul class="pagination"></ul>


<?php $id=getREQUEST('_Id');if(!$id) $id='0'; ?>
        <script>PageMe_Dynamic(<?php echo $tot_page; ?>,<?php echo $start_page; ?>,<?php echo $per; ?>,false,<?php echo $id;?>);</script>
