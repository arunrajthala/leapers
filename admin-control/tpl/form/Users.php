<?php //var_dump($_data); ?>
<table width="100%" cellspacing="0" cellpadding="0" class="admTable table">
<tbody>
    <tr>
        <td>
            
        </td>
        <td>
            <input type="hidden" value="<?php echo $_data[$prefix.'uin']; ?>"  name="<?php echo 'uin'; ?>">
            <input type="hidden" value="100"  name="<?php echo 'us00uin'; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <label >Name: </label>
        </td>
        <td>
            <input required  class="input_field"  type="Text" value="<?php if($_data[$prefix.'username']) echo $_data[$prefix.'username']; ?>"  name="<?php echo 'username';?>">
        </td>
    </tr>
    <tr>
        <td>
            <label >Email: </label>
        </td>
        <td>
            <input required  class="input_field"  type="Text" value="<?php if($_data[$prefix.'email']) echo $_data[$prefix.'email']; ?>"  name="<?php echo 'email';?>">
        </td>
    </tr>
    <tr>
        <td>
            <label >Access Level: </label>
        </td>
        <td>
            <select name="us01uin" class="input_field">
                <?php 
                    $dbUserModule=new userModule();
                    $SQL="SELECT * FROM us00usertype where us00rights < ".$dbUserModule->getCurrentRight();
                    $userTypes=Query($SQL);
                    foreach($userTypes as $row1)
                    {
                        $selected='';
                        if($row1['us00uin']==$_data['us01us00uin'])
                        {
                            $selected='selected';
                        }
                        
                        echo '<option '.$selected.' value="'.$row1['us00uin'].'">'.$row1['us00title'].'</option>';
                    }
                ?>
                
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <label>&nbsp;</label>
        </td>
        <td>
            <input type="submit" class="submit" value="Update" name="sub"><input type="button" class="submit" onclick="history.back();" value="Back" name="cmdBack">
        </td>
    </tr>
</tbody>
</table>
