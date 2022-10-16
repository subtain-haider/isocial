<div class="one-hashtag-trend">
	<div class="ont-thehash"><a href="<?php echo $K->SITE_URL; ?>hashtag/<?php echo($D->oh_hashtag); ?>" <?php echo($D->_IS_LOGGED ? 'rel="phantom-all" target="dashboard-main-area"' : '') ?>>#<?php echo $D->oh_hashtag; ?></a></div>
	<div class="ont-theposts"><?php echo $D->oh_frequency; ?> <?php echo($D->oh_frequency == 1 ? $this->lang('global_txt_post') : $this->lang('global_txt_posts')); ?></div>
</div>