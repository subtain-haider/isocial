<div id="langs-pseudo-foot" class="space-box" style="margin-top:10px;">
<script>
var msg_alert_changelang = stripslashes('<?php echo $this->designer->boxConfirm($this->lang('global_alert_changelang_title'), $this->lang('global_alert_changelang_message'), $this->lang('global_alert_changelang_ok'), $this->lang('global_alert_changelang_cancel'))?>');
</script>

<?php
    require_once($K->INCPATH.'helpers/languages.php');
    foreach(get_available_languages() as $k=>$v) {
        ?>
        <?php if ($K->LANGUAGE != $k) { ?>
        <span class="one-option-lang-foot oolf-active"><a href="#" rel="language" data-lang="<?php echo $k; ?>"><span><?php echo $v->name; ?></span></a></span>
        <?php } else { ?>
        <span class="one-option-lang-foot oolf-inactive"><?php echo $v->name; ?></span>
        <?php } ?>
        <?php
    }
?>
</div>


<div style="padding:10px 8px 0; margin-bottom:20px;">

    <div>

    <?php

    $statics = getStaticsFoot();

    if ($statics) {

        foreach ($statics as $onest) { ?>

        <span class="link link-grey" style="padding-right:10px;"><a href="<?php echo $K->SITE_URL.'info/'.$onest->url?>" <?php echo($D->_IS_LOGGED ? 'rel="phantom-all" target="dashboard-main-area"' : '') ?>><span style="word-wrap: break-word;"><?php echo $onest->title ?></span></a></span>

    <?php 

        }

    } ?>

    </div>

    <div style="color:#90949c; margin-top:5px;"><?php echo $K->COMPANY?> &copy; <?php echo date('Y'); ?></div>

</div>