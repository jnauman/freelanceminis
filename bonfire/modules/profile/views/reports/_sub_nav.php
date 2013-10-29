<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/profile') ?>" id="list"><?php echo lang('profile_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Profile.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/profile/create') ?>" id="create_new"><?php echo lang('profile_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>