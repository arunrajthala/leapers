<?php //var_dump($obj) ?>
<div class="headline"><?php echo $module_Title; ?></div>
<?php
    
   include_once(ADMIN_TPL_MODULE.'includes/message.php');
?>
<form method="post" enctype="multipart/form-data">
<?php 
if (isset($_GET['action']))
{
?>
    <div class="top_bar">
        <a href="home.php?module=<?php echo $_GET['module'];if(getREQUEST('Type') )echo '&Type='.getREQUEST('Type')?>"><img src="../css/img/back.png" height="32px" width="32px"/>Back</a>
    </div>
    
        <div class="cleaner"></div>
                    <div class="subhead">
    				    <?php include(ADMIN_TPL_MODULE.'form/'.$_GET['module'].'.php'); ?>
    				</div>
        
<?php 
    
       
}
else
{
        
  
?>

<div class="top_bar"><a href="home.php?module=<?php echo $_GET['module'];if(getREQUEST('Type') )echo '&Type='.getREQUEST('Type') ?>&action=add"><img src="../css/img/add.png" height="32px" width="32px"/>Add <?php echo $module_Title; ?></a></div>
<div id="dynamic"></div>

    
 
    <?php //$lists=$obj->getListField();?>
  <table width="100%" cellspacing="0" cellpadding="0" border="0" id="_table" class="display dataTable" aria-describedby="_table_info" style="width: 100%;">
	<thead>
		<tr role="row">
            <th class="sorting_asc" role="columnheader" >SN</th>
            <?php while($row = current($lists))
            {
                //var_dump($list_fields);
                echo '<th class="sorting" role="columnheader"  >'.key($lists).'</th>';
                next($lists);
            }
            if(isset($_extraModule))
            {
                foreach($_extraModule as $row)
                {
                    echo '<th class="sorting" role="columnheader"  >'.$row[0].'</th>';
                }
            }
            ?>
<!--            
<th class="sorting" role="columnheader" >Scrolling</th>
-->
            <th class="sorting" role="columnheader" >Headline</th>

            <th class="sorting" role="columnheader"  >Action</th>
            
	</thead>
	<?php ?>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
        
            <?php
                //$_fieldlist='trip02uin,  trip02title,    trip02banner';
                //$result=$obj->select("select $fieldlist from $table");
                
                $ct=1;
                //var_dump($_data);die();
                $strqry='';
                $exArr=array('module','delete');
                foreach($_GET as $k=>$gets)
                {
                    
                    if(!in_array($k,$exArr))
                        $strqry.= '&'.$k.'='.$gets;
                }
                foreach( $_data as $row )
                {
                    //var_dump($row);
                    echo'<tr><td class="sorting_1">'.$ct.'</td>';
                    foreach($list_fields as $v)
                    {
                        //var_dump($list_fields);
                        echo '<td class=""  >'.$row[$prefix.$v].'</td>';
                        //next($lists);
                    }
                    if(isset($_extraModule))
                    {
                       foreach($_extraModule as $row1)
                        {
                            echo '<td class=""  ><a href="home.php?module='.$row1[1].'&_Id='.$row[$prefix.'uin'].'">'.$row1[0].' </a></td>';
                        } 
                    }
                    
            ?>
                   
                    <!--
<td class="  sorting_1">
                        <a href="home.php?module=changeNewsType<?php if(getREQUEST('Type') )echo '&Type='.getREQUEST('Type')?>&action=<?php echo NEWS_SCROLLING ?>&_Id=<?php echo $row[$prefix.'uin'];?>">
                            <img src="../img/<?php if ($row[$prefix.'scrolling']) echo 'conduct';  else echo 'deactivate';?>.png" height="16px" width="16">
                        </a> 
                    </td>
                    -->
                    <td class="  sorting_1">
                        <a href="home.php?module=changeNewsType<?php if(getREQUEST('Type') )echo '&Type='.getREQUEST('Type')?>&action=<?php echo NEWS_HIGHLIGHT ?>&_Id=<?php echo $row[$prefix.'uin'];?>">
                            <img src="../img/<?php if ($row[$prefix.'highlight']) echo 'conduct';  else echo 'deactivate';?>.png" height="16px" width="16">
                        </a> 
                    </td>

                    <td class="center"><a href="home.php?module=<?php echo $_GET['module'];?>&amp;action=edit&amp;_Id=<?php echo $row[$prefix.'uin'];if(getREQUEST('Type') )echo '&Type='.getREQUEST('Type')?>">
                        <img height="16px" width="16" src="../css/img/edit.png"></a> | 
                        <a onclick="delData(this.id,'<?php echo $strqry ?>')" href="#" id="<?php echo $_GET['module'].'|'.$row[$prefix.'uin'] ;?>">
                                <img height="16px" width="16" src="../css/img/delete.png"></a></td>
                    
            <?php 
                    $ct++;
            
                }
            ?>
			
		
        </tbody>
  </table>
        <script>
                $(document).ready(function() {
                    $('#_table').dataTable({"aLengthMenu": [[ 25, 50, -1], [ 25, 50, "All"]],"iDisplayLength": 25});
                } );
                    
                </script>
  
  <?php //endif ?>
  <?php }?>
  </form>