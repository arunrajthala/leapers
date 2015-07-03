<?php
    $per=NEWS_PER_PAGE;
    $start_page=1;
    //echo $data->rowCount();
    //$tot_page=ceil(($data->rowCount())/$per);
    //echo $tot_page;
?>
<header class="heading">
                	<h1>समाचार</h1>
                </header>
                <ul class="pagination"></ul>
			<div class="content-holder text-justify"  id="newsList">
            </div>
                <ul class="pagination"></ul>
                


<?php $id=getREQUEST('_Id');if(!$id) $id='0'; ?>
        <script>PageMe_Dynamic(<?php echo $tot_page; ?>,<?php echo $start_page; ?>,<?php echo $per; ?>,false,<?php echo $id;?>);</script>
