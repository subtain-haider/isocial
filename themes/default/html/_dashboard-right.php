<div id="space-dashright">

    <?php $this->load_template('_advertising-right.php'); ?>

    <?php if ($K->WITH_HASHTAGS) { ?>
    	<?php if (isset($D->html_hashtags) && !empty($D->html_hashtags)) { ?>
	<?php $this->load_template('_trending-right-w.php'); ?>
		<?php } ?>
    <?php } ?>
    
    <?php if (isset($D->SHOW_SUGGESTIONS_PEOPLE) && $D->SHOW_SUGGESTIONS_PEOPLE) { ?>

    <?php $this->load_template('_users-right-w.php'); ?>

    <?php } ?>

</div>

<?php $this->load_template('_pseudo-foot.php'); ?>

<script>
$('#dashboard-main-right').theiaStickySidebar({additionalMarginTop: 52});
</script>