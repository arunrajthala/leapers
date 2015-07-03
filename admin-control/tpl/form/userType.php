<?php //var_dump($_data); ?>
<table width="100%" cellspacing="0" cellpadding="0" class="admTable table">
<tbody>
    <tr>
        <td>
            
        </td>
        <td>
            <input type="hidden" value="<?php echo $_data[$prefix.'uin']; ?>" id="trip02uin" name="<?php echo 'uin'; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <label >Title: </label>
        </td>
        <td>
            <input required  class="input_field"  type="Text" value="<?php if($_data[$prefix.'title']) echo $_data[$prefix.'title']; ?>"  name="<?php echo 'title';?>">
        </td>
    </tr>
    <tr>
        <td>
            <label >Rights: </label>
        </td>
        <td>
            <input required  class="input_field"  type="Text" value="<?php if($_data[$prefix.'rights']) echo $_data[$prefix.'rights']; ?>"  name="<?php echo 'rights';?>">
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
