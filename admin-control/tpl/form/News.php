

<script type="text/javascript" src="../js/admin/nepali_converter.js"></script>
<link rel="stylesheet" type="text/css" href="../css/admin/jquery-ui-1.8.19.custom.css" />

<script language="javascript" type="text/javascript"> 
        function limitText(limitField, limitCount, limitNum) {
            //alert('limiting text');
            if (limitField.value.length > limitNum) {
                limitField.value = limitField.value.substring(0, limitNum);
            } else {
                limitCount.value = limitNum - limitField.value.length;
            }
        }
 
</script>
<?php 
    $limitText = 512;
?>

<table width="100%" cellspacing="0" cellpadding="0" class="admTable table">
<input type="hidden" value="<?php echo $_data[$prefix.'uin']; ?>" id="trip02uin" name="<?php echo 'uin'; ?>">
<input  type="hidden" name="news01uin" value="<?php echo getREQUEST('Type');//'.'uin'; ?>"/>
<tbody>
    
    
    <tr>
        <td>
            <label >Title: </label>
        </td>
        <td>
            <input required   class="input_field" type="Text" value="<?php if($_data[$prefix.'title']) echo $_data[$prefix.'title']; ?>"  name="<?php echo 'title';?>">
        </td>
    </tr>
    <!--
<tr>
        <td>
            <label >Short Description: </label>
        </td>
        <td>
            <textarea onkeydown="limitText(this.form.<?php echo $prefix.'shortDesc';?>,this.form.countdown,<?php echo $limitText?>);" onkeyup="limitText(this.form.<?php echo $prefix.'shortDesc';?>,this.form.countdown,<?php echo $limitText?>);" id="<?php echo $prefix.'shortDesc';?>"  name="<?php echo 'shortDesc';?>" ><?php if($_data[$prefix.'shortDesc']) echo  trim($_data[$prefix.'shortDesc']); ?></textarea>
            <input required   type="text" name="countdown" size="3" value="<?php echo $limitText?>" readonly="readonly" class="normal" /> [characters left]
            
        </td>
    </tr>
-->
    <tr>
        <td>
            <label > Description: </label>
        </td>
        <td>
            <textarea id="<?php echo 'detail';?>"   name="<?php echo 'detail';?>" class="ckeditor"><?php if($_data[$prefix.'detail']) echo $_data[$prefix.'detail']; ?></textarea>
            <script type="text/javascript">
                CKEDITOR.replace( '<?php echo 'detail';?>',{
                    toolbar : 'MyToolbar' ,
                     filebrowserBrowseUrl : '<?php echo BASE_ADMIN_URL;  ?>ckfinder/ckfinder.html',
                    filebrowserUploadUrl : '<?php echo BASE_ADMIN_URL; ?>ckfinder/userfiles/',
                    allowedContent: 'p';
                } );
            </script>
        </td>
    </tr>
    
    <tr>
        <td>
            <label >Date: </label>
        </td>
        <td>
            <input  required  class="input_field" id="datepicker"  type="Text" value="<?php 
 if($_data[$prefix.'date']){$date = new DateTime($_data[$prefix.'date']);echo $date->format('Y-m-d');}  ?>" name="<?php echo 'date';?>">
        </td>
    </tr>
    
    <tr>
        <td>
            <label >Image: </label>
        </td>
        <td>
            <input type="file"  id="file" name="<?php echo 'file';?>"/>
            <?php if($_data[$prefix.'file']){?>
                                <img style="width: 150px;" src="<?php echo $uploadUrl.$_data[$prefix.'file']; ?>">
                                <a href="<?php echo curPageURL();if(getREQUEST('deletefile')=='') echo '&deletefile=1'; ?>">Delete File</a>
                                <?php } ?>
            
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
<script>
//InitializeUnicodeNepali();

 $( document ).ready(function() {
    $( "#datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"/*,
                onSelect: function() { $(this).valid(); }*/
                });
    });
</script>

