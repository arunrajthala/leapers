<?php //var_dump($_data); ?>
<table width="100%" cellspacing="0" cellpadding="0" class="admTable table">
	<tbody>
		<tr>
			<td>

			</td>
			<td>
				<input class="input_field"  type="hidden" value="<?php echo $_data[$prefix . 'uin']; ?>" id="trip02uin" name="<?php echo 'uin'; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label >Title: </label>
			</td>
			<td>
				<input class="input_field"  type="Text" value="<?php if ($_data[$prefix . 'title']) echo $_data[$prefix . 'title']; ?>"  name="<?php echo 'title'; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label >Module Name: </label>
			</td>
			<td>
				<input class="input_field"  type="Text" value="<?php if ($_data[$prefix . 'module']) echo $_data[$prefix . 'module']; ?>"  name="<?php echo 'module'; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label > Description: </label>
			</td>
			<td>
				<textarea  name="<?php echo 'detail' ?>" class="ckeditor"><?php if ($_data[$prefix . 'detail']) echo $_data[$prefix . 'detail']; ?></textarea>

			</td>
		</tr>

		<tr>
			<td>
				<label >Sort Order: </label>
			</td>
			<td>
				<input class="input_field"  type="text" value="<?php if ($_data[$prefix . 'sortOrder']) echo $_data[$prefix . 'sortOrder']; ?>"  name="<?php echo 'sortOrder'; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label >URL: </label>
			</td>
			<td>
				<input class="input_field"  type="text" value="<?php if ($_data[$prefix . 'url']) echo $_data[$prefix . 'url']; ?>"  name="<?php echo 'url'; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label >Parent: </label>
			</td>
			<td>
				<select name="parent">
					<option value="0">None</option>
					<?php $ObjnewsType = new NewsType();
					$data_newstype = $ObjnewsType->getByParent(0) ?>
					<?php foreach ($data_newstype as $row): $selected = '';
						if ($_data[$prefix . 'parent'] == $row[$prefix . 'uin']) $selected = 'selected'; ?>
						<option <?php echo $selected ?> value="<?php echo $row[$prefix . 'uin'] ?>"><?php echo $row[$prefix . 'title'] ?></option>
<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label >Options:</label >
			</td>
			<td>
				<label ><input type="checkbox" <?php if ($_data[$prefix . 'hasChild']) echo 'checked'; ?>  name="<?php echo 'hasChild'; ?>"> Has Child </label><br />
				<label ><input type="checkbox" <?php if ($_data[$prefix . 'backend']) echo 'checked'; ?>  name="<?php echo 'backend'; ?>"> Backend</label><br />
				<label ><input type="checkbox" <?php if ($_data[$prefix . 'menu']) echo 'checked'; ?>  name="<?php echo 'menu'; ?>"> Not in Main menu</label>

			</td>
		</tr>
		<tr>
			<td>
				<label >Icon: </label>
			</td>
			<td>
				<input  class="input_field" type="file"  id="file" name="<?php echo 'file'; ?>"/>
<?php if (isset($_data[$prefix . 'file']) && $_data[$prefix . 'file'] != 0) echo '<img src="' . $uploadUrl . 'thumb/' . $_data[$prefix . 'file'] . '" width="150" />'; ?>
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
