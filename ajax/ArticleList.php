
<?php
include_once('../system/config.php');
include_once('../system/functions.php');
    $page=$_GET['page'];
    $per=$_GET['per'];
    $where=$_GET['where'];
    $order=$_GET['order'];
    $module=$_GET['module'];
    
    $prefix=$_GET['prefix'];
    $table=$_GET['module'];
    $upURL=$_GET['upURL'];
    $uploadUrl='uploads/'.$upURL.'/';
    if(isset($_GET['moduleName']))
    {
        if($_GET['moduleName']!='')
            $moduleName=$_GET['moduleName'];
        else
            $moduleName=$upURL;
    }
        
    else
        $moduleName=$upURL;
    if($where=='')
    {
        $where=$prefix.'uin>0';
    }
    
    
    $SQL='select * from '.$table.' where '.$where.' order by '.$prefix.'uin  desc limit '.($page-1)*$per.','.$per;
    //echo $SQL;//die();
    $_data=Query($SQL);
    
?>
<?php foreach($_data as $row): ?>
<div class="news-items  clearfix"> <img src="<?php echo $uploadUrl.$row[$prefix.'file']; ?>" class="img-responsive" alt="<?php echo $row[$prefix.'title'.$_SESSION['lang_type']]; ?>">
    <div class="shadow">
      <h5><a href="<?php echo getSiteLink($moduleName,'',$row[$prefix.'title'],$row[$prefix.'uin']); ?>">
        <?php echo clipMyText($row[$prefix.'detail'],500); ?>
        </a></h5>
      <p class="bg2"><?php echo $row[$prefix.'title'.$_SESSION['lang_type']]; ?></p>
	  <a class="" href="<?php echo getSiteLink($moduleName,'',$row[$prefix.'title'],$row[$prefix.'uin']); ?>">Read More..</a>
       </div>
  </div>

<?php endforeach ; ?>
<div class="clearfix"></div>
