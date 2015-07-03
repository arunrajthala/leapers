<?php
    //include_once(ADMIN_TPL_MODULE.'includes/generallisting_v2.php');
    $table='set02modules';
    $SQL="SELECT * FROM set02modules";
    $module=Query($SQL  );
    
    $SQL="SELECT M.*,U.* FROM $table M   JOIN us02modules U ON  M.set02uin=U.us02set02uin where us02us01uin='".getREQUEST('_Id')."'";
    $SQL1="SELECT * FROM us01users where us01uin=".getREQUEST('_Id');
    $userData=Query($SQL1);
    //var_dump($userData);
    //echo $SQL;
    
    $data=Query($SQL);
    //var_dump($data);
    $_data=array();
    foreach($module as $row_module)
    {
        //var_dump($row_module);
        $newRow=array();
        foreach($data as $row)
        {
            if($row_module['set02uin']==$row['us02set02uin'])
            {  
                $newRow=$row;
            }
        }
        if(empty($newRow))
        {
            $newRow=$row_module;
        }
            array_push($_data,$newRow);
    }
    
?>
<div class="headline">User module for <?php echo $userData[0]['us01username'] ?></div>
<?php
    
   include_once(ADMIN_TPL_MODULE.'includes/message.php');
?>
<?php
    
   if($message)
    {
        echo '<div class="headline1">'.$message.'</div>';
    } 
?>
<form method="post" enctype="multipart/form-data">

<div class="top_bar"><a href="home.php?module=<?php echo $_GET['module']; ?>&action=add"><img src="../css/img/add.png" height="32px" width="32px"/>Add <?php echo $module_Title; ?></a></div>
<div id="dynamic"></div>

    
 
    <?php $lists=$list_fields;?>
  <table width="100%" cellspacing="0" cellpadding="0" border="0" id="_table" class="display dataTable" aria-describedby="_table_info" style="width: 100%;">
	<thead>
		<tr role="row">
            <th class="sorting_asc" role="columnheader" >SN</th>
            <th class="sorting" role="columnheader" >Module</th>
            <th class="sorting" role="columnheader" >View</th>
            <th class="sorting" role="columnheader" >Add/Edit</th>
            <th class="sorting" role="columnheader" >Delete</th>
        </tr>
	</thead>
	<?php ?>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
        
            <?php
                //$_fieldlist='trip02uin,  trip02title,    trip02banner';
                //$result=$obj->select("select $fieldlist from $table");
                
                $ct=1;
                //var_dump($_data);
                foreach( $_data as $row )
                {
                   //var_dump($row);
            ?>
                    <tr>
                        <td><?php echo $ct; ?></td>
                        <td><?php echo $row['set02name'];; ?></td>
                        <td><a href="home.php?module=changeAccess&action=<?php echo ACCESS_VIEW ?>&_Id=<?php if(isset($row['us02uin'])) echo $row['us02uin']; else echo '0'.'&mod_id='.$row['set02uin'];echo '&userId='.getREQUEST('_Id'); ?>">
                            <img src="../img/<?php if (isset($row['us02view']) && $row['us02view']) echo 'conduct';  else echo 'deactivate';?>.png" height="16px" width="16">
                        </a> </td>
                        <td><a href="home.php?module=changeAccess&action=<?php echo ACCESS_ADD ?>&_Id=<?php if(isset($row['us02uin'])) echo $row['us02uin']; else echo '0'.'&mod_id='.$row['set02uin'];echo '&userId='.getREQUEST('_Id'); ?>">
                            <img src="../img/<?php if (isset($row['us02add'])&& $row['us02add']) echo 'conduct';  else echo 'deactivate';?>.png" height="16px" width="16">
                        </a></td>
                        <td><a href="home.php?module=changeAccess&action=<?php echo ACCESS_DELETE?>&_Id=<?php if(isset($row['us02uin'])) echo $row['us02uin']; else echo '0'.'&mod_id='.$row['set02uin'];echo '&userId='.getREQUEST('_Id'); ?>">
                            <img src="../img/<?php if (isset($row['us02delete'])&& $row['us02delete']) echo 'conduct';  else echo 'deactivate';?>.png" height="16px" width="16">
                        </a></td>
                        
                    </tr>
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
 
  </form>