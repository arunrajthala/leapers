<table width="100%" cellspacing="0" cellpadding="0" class="admTable table">
<tbody>
    <tr>
        <td>
            
        </td>
        <td>
            <input class="input_field"  type="hidden" value="<?php echo $_data[$prefix.'uin']; ?>" id="trip02uin" name="<?php echo 'uin'; ?>">
        </td>
    </tr>
    <tr style="display: none;">
        <td>
            <label >Title: </label>
        </td>
        <td>
            <input class="input_field"  type="Text" value="<?php if($_data[$prefix.'title']) echo $_data[$prefix.'title']; ?>"  name="<?php echo 'title';?>">
        </td>
    </tr>
    <tr style="display: none;">
        <td>
            <label >Module Name: </label>
        </td>
        <td>
            <input class="input_field"  type="Text" value="<?php if($_data[$prefix.'module']) echo $_data[$prefix.'module']; ?>"  name="<?php echo 'module';?>">
        </td>
    </tr>
    <tr>
        <td>
            <label > Description: </label>
        </td>
        <td>
            <textarea  name="<?php echo 'detail'?>" class="ckeditor">
                <?php if($_data[$prefix.'detail']) echo $_data[$prefix.'detail']; ?>
            </textarea>
            
        </td>
    </tr>
    
    <tr style="display: none;">
        <td>
            <label >Sort Order: </label>
        </td>
        <td>
            <input class="input_field"  type="text" value="<?php if($_data[$prefix.'sortOrder']) echo $_data[$prefix.'sortOrder']; ?>"  name="<?php echo 'sortOrder';?>">
        </td>
    </tr>
    <tr style="display: none;">
        <td>
            <label >URL: </label>
        </td>
        <td>
            <input class="input_field"  type="text" value="<?php if($_data[$prefix.'url']) echo $_data[$prefix.'url']; ?>"  name="<?php echo 'url';?>">
        </td>
    </tr>
    <tr style="display: none;">
        <td>
            <label >Options:</label >
        </td>
        <td>
            <label >Has Child:<input type="checkbox" <?php if($_data[$prefix.'hasChild']) echo 'checked'; ?>  name="<?php echo 'hasChild';?>"> </label>
            <label >Backend:<input type="checkbox" <?php if($_data[$prefix.'backend']) echo 'checked'; ?>  name="<?php echo 'backend';?>"> </label>
        </td>
    </tr>
    <tr >
        <td>
            <label >Image: </label>
        </td>
        <td>
            <input  class="input_field" type="file"  id="file" name="<?php echo 'image';?>"/>
            <?php  if(isset($_data[$prefix.'image']) && $_data[$prefix.'image'] !=0)
                    {
                      echo '<img src="'.$uploadUrl.'thumb/'.$_data[$prefix.'image'].'" widht="150" />' ;   
            ?>
                        <a href="<?php echo curPageURL();if(getREQUEST('deletefile')=='') echo '&deletefile=1&field=image'; ?>">Delete File</a>
            <?php
                    } 
            ?>
            
        </td>
    </tr>
    <tr >
        <td>
            <label>&nbsp;</label>
        </td>
        <td>
            <input type="submit" class="submit" value="Update" name="sub"><input type="button" class="submit" onclick="history.back();" value="Back" name="cmdBack">
        </td>
    </tr>
</tbody>
</table>
