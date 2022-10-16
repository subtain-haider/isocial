<?php $this->load_template('_header.php'); ?>

<div id="generic-top-area">
    <?php $this->load_template('_top.php'); ?>
</div>

<div id="generic-main-area">

    <div id="area-register">
        <div id="titleform"><?php echo $this->lang('signup_validation_title')?></div>
        <div id="msgfree"><?php echo $this->lang('signup_validation_subtitle')?></div>
        
        <div style="padding:40px 0; text-align:center;">
            <div style="font-size:14px;">
            <?php 
            if ($D->status_val == 0) echo($this->lang('signup_validation_msg3'));
            if ($D->status_val == 1) echo($this->lang('signup_validation_msg2'));
            if ($D->status_val == 2) echo($this->lang('signup_validation_msg1'));
            ?>
            </div>
            
            <?php if ($D->status_val != 0) { ?>
            <div style="margin-top:40px; font-size:15px;">
                <span class="link link-blue"><a href="<?php echo $K->SITE_URL;?>login"><?php echo($this->lang('signup_validation_msg4')); ?></a></span>
            </div>
            <?php } ?>
        
        </div>

    </div>

</div>

<div id="generic-foot-area">
<?php $this->load_template('_foot-out.php'); ?>
</div>

<?php $this->load_template('_footer.php'); ?>