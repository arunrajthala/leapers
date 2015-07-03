<div class="headline"><?php echo $module_Title; ?></div>
<?php
    
   if($message)
    {
        echo '<div class="headline1">'.$message.'</div>';
    } 
?>
<form method="post" enctype="multipart/form-data">
<?php 
if (isset($_GET['action']))
{
?>
    <div class="top_bar">
        <a href="home.php?module=<?php echo $_GET['module'];?>"><img src="../css/img/back.png" height="32px" width="32px"/>Back</a>
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

<div class="top_bar"><a href="home.php?module=<?php echo $_GET['module']; ?>&action=add"><img src="../css/img/add.png" height="32px" width="32px"/>Add <?php echo $module_Title; ?></a></div>
<div id="dynamic"></div>

    
  
  <script>
    cacheArray=[];
    
  </script>
    <?php $lists=$list_fields;?>
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
            ?>
            
            <th class="sorting" role="columnheader"  >Action</th>
            
	</thead>
	<?php ?>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
        
            <?php
                //$_fieldlist='trip02uin,  trip02title,    trip02banner';
                //$result=$obj->select("select $fieldlist from $table");
                
                $ct=1;
                foreach( $_data as $row )
                {
                    //var_dump($row);
                    echo'<tr><td class="sorting_1">'.$ct.'</td>';
                    foreach($list_fields as $v)
                    {
                        //var_dump($list_fields);
                        echo '<td class=""  >'.$row[$v].'</th>';
                        //next($lists);
                    }
            ?>
                   
                    
                    <td class="center"><a href="home.php?module=<?php echo $_GET['module'];?>&amp;action=edit&amp;_Id=<?php echo $row[$_id];?>">
                        <img height="16px" width="16" src="../css/img/edit.png"></a> | 
                        <a onclick="test(this.id)" href="#" id="<?php echo $_GET['module'].'|'.$row[$_id] ;?>">
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