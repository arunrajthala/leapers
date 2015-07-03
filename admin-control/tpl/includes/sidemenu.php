<div id="menu" class="sidemenu" style="background: #FFF;">

    <ul class="left-section verticalmenu"  style="min-height: 400px;">
		<li id="title-box">Menu</li>

		<!--

		<li class="<?php if (getREQUEST('module') == 'Users') echo 'active'; ?>">
			<a href="home.php?module=Slider">
			<img src="../uploads/admin/slider.png">
			Slider
			</a>
		</li>

		-->
		<?php $ObjnewsType = new NewsType();
		$menudata = $ObjnewsType->get(array('backend' => '1')); //var_dump($menudata); ?>
		<?php foreach ($menudata as $row): ?>
			<?php
			$active = '';
			$curr_mod_type = '';
			if ($row[$ObjnewsType->getPrefix() . 'url'] != 1) {
				$url = '<a href="home.php?module=' . $row[$ObjnewsType->getPrefix() . 'url'] . '">';
				if (getREQUEST('module') == $row[$ObjnewsType->getPrefix() . 'url']) {
					$active = 'active';
				}
			} elseif ($row['news01hasChild']) {
				$url = '<a href="home.php?module=News&Type=' . $row['news01uin'] . '">';
				if (getREQUEST('Type') == $row['news01uin']) {
					$active = 'active';
				}
			} else {
				$url = '<a href="home.php?module=NewsType&action=edit&_Id=' . $row['news01uin'] . '">';
				if (getREQUEST('_Id') == $row['news01uin']) {
					$active = 'active';
				}
			}
			?>
			<li class="<?php echo $active; ?>">
			<?php echo $url; ?>
				<img src="../uploads/newstype/thumb/<?php if (isset($row['news01file']) && ($row['news01file'] != '')) echo $row['news01file'];
		else echo 'noicon.png'; ?>">
			<?php echo $row['news01title']; ?>
				</a>
			</li>
		<?php endforeach; ?>
		<?php
		$objUser = new Users();
		$currUser = $objUser->getCurrentUser();
		//var_dump($currUser);
		if ($currUser['us01us00uin'] > 100):
			if (getREQUEST('module') == 'admin_newstype') {
				$active = 'active';
			} else {
				$active = '';
			}
			?>
			<li class="<?php echo $active; ?>">
			<?php echo '<a href="home.php?module=admin_newstype">'; ?>
				<img src="../css/img/admin.png"/>
			<?php echo 'Super Setting'; ?>
				</a>
			</li>
			<?php
			if (getREQUEST('module') == 'users') {
				$active = 'active';
			} else {
				$active = '';
			}
			?>
			<li class="<?php echo $active; ?>">
				<?php echo '<a href="home.php?module=Users">'; ?>
				<img src="../css/img/user.png"/>
				<?php echo 'Users'; ?>
				</a>
			</li>
			<?php
			if (getREQUEST('module') == 'Password_enc') {
				$active = 'active';
			} else {
				$active = '';
			}
			?>
			<li class="<?php echo $active; ?>">
			<?php echo '<a href="home.php?module=Password_enc">'; ?>
				<img src="../css/img/user.png"/>
				<?php echo 'Password Encryptor'; ?>
				</a>
			</li>
				<?php
			else:
				?>

		<?php
		endif;
		?>


		</li>
	</ul>
</div>
<style>
    .sidemenua{
        background-color: azure;
    }
</style>