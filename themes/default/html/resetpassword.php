<?php $this->load_template('_header.php'); ?>

<div id="generic-top-area">
    <?php $this->load_template('_top.php'); ?>
</div>

    <div id="area-resetpass" style="margin-bottom:120px;">
        <div id="titleform"><?php echo $this->lang('login_reset_title')?></div>


        <div style="font-size:14px; text-align:center;">
        
            <?php if ($D->status_reset == 0) { ?>
            <div id="msg-error-reset"><?php echo($this->lang('resetpass_msg1')); ?></div>
            <?php } ?>
            
            <?php if ($D->status_reset == 1) { ?>
            <div style="font-size:16px; font-weight:bold; margin-bottom:25px;"><?php echo($this->lang('resetpass_msg5')); ?></div>
            <div id="msg-reset-info-new">
                <div style="margin-bottom:10px;"><?php echo($this->lang('resetpass_msg2').': <span style="font-weight:bold;">'.$D->theusername); ?></span></div>
                <div style="margin-bottom:10px;"><?php echo($this->lang('resetpass_msg3').': <span style="font-weight:bold;">'.$D->newpas.'</span>'); ?></span></div>
            </div>
            <?php } ?>
            
            <?php if ($D->status_reset != 0) { ?>
            
            <div style="margin-top:40px;"><span class="link link-blue"><a href="<?php echo $K->SITE_URL; ?>login" target="_blank"><?php echo($this->lang('resetpass_msg4')); ?></span></a>
            </div>
            <?php
            }
            ?>

        
        </div>

    </div>

<div id="generic-foot-area">
<?php $this->load_template('_foot-out.php'); ?>
</div>

<?php $this->load_template('_footer.php'); ?>