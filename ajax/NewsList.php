
<?php
include_once('../system/config.php');
include_once('../system/functions.php');
$order='';
$prefix='news02';
    $page=$_GET['page'];
    $per=$_GET['per'];
    $where='';
    if($_GET['where']!='')
    {
        if($_GET['where']=='POPULAR')
        {
            $where=$prefix.'hits>0 and '.$prefix.'date between  DATE_ADD(NOW(), INTERVAL -30 DAY) AND NOW()';
            $order=$prefix.'hits desc';
        }
        else
        {
              $where=$prefix.$_GET['where'];  
        }
        
    }
    
    //echo $where;die();
    //echo $page;
    
    $objNews=new News();
    
    
    
    
    $_data=$objNews->get($where,$order,$per,$page);
    //var_dump($_data);die();
    $uploadUrl=UPLOADS.$objNews->getUploadURL().'thumb/';
    
?>
<?php foreach($_data as $row): ?>
<div class="news-items  clearfix">
    <?php echo LoadMyImage($uploadUrl,$row[$prefix.'file'],$row[$prefix.'title'],'img-responsive') ?>
     
    <div class="shadow">
      <h5><a href="<?php echo getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin']); ?>">
        <?php echo $row[$prefix.'title']; ?>
        
        </a></h5>
      <p class="bg2"><?php echo clipMyText($row[$prefix.'detail'],500); ?></p>
	  <a class="" href="<?php echo getSiteLink('NewsArticle','',$row[$prefix.'title'],$row[$prefix.'uin']); ?>">Read More..</a>
       </div>
  </div>

<?php endforeach ; ?>
<div class="clearfix"></div>

