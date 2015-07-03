<table width="100%" cellspacing="0" cellpadding="0" class="admTable table">
	<tbody>
		<tr>
			<td>

			</td>
			<td>
				<input class="input_field"  type="hidden" value="<?php echo $_data[$prefix . 'uin']; ?>"  name="<?php echo 'uin'; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label >Options:</label >
			</td>
			<td>

				<label ><input type="checkbox" <?php if ($_data[$prefix . 'create']) echo 'checked'; ?>  name="<?php echo 'create'; ?>"> Create </label><br />
				<label ><input type="checkbox" <?php if ($_data[$prefix . 'udpate']) echo 'checked'; ?>  name="<?php echo 'update'; ?>"> Update</label><br />
				<label ><input type="checkbox" <?php if ($_data[$prefix . 'alter']) echo 'checked'; ?>  name="<?php echo 'alter'; ?>"> Alter </label><br />
				<label ><input type="checkbox" <?php if ($_data[$prefix . 'delete']) echo 'checked'; ?>  name="<?php echo 'delete'; ?>"> Delete </label><br />
				<label ><input type="checkbox" <?php if ($_data[$prefix . 'truncate']) echo 'checked'; ?>  name="<?php echo 'truncate'; ?>"> Truncate</label>

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
