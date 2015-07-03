<div class="headline"><?php echo $module_Title; ?></div>
<div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" id="_table" class="display dataTable" aria-describedby="_table_info" style="width: 100%;">
		<thead>
			<tr role="row">
				<th class="sorting_asc" role="columnheader" >Table Name</th>
				<th class="sorting" role="columnheader"  >Action</th>
			</tr>
		</thead>

		<tbody role="alert" aria-live="polite" aria-relevant="all">
			<?php foreach ($tableList as $table): ?>
				<tr>
					<td class="sorting_1">

						<?php echo $table['Tables_in_db_hacker']; ?>

					</td>
					<td> <a href="home.php?module=filter&amp;_Id=<?php echo $table['Tables_in_db_hacker']; ?>">Monitor</a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="clearfix"></div>
<script>
    $(document).ready(function() {
        $('#_table').dataTable({"aLengthMenu": [[25, 50, -1], [25, 50, "All"]], "iDisplayLength": 25});
    });

</script>
