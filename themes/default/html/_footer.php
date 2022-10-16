
<?php 
global $D;
if (isset($D->_WITH_NOTIFIER) && $D->_WITH_NOTIFIER) {
?>
    <script>
        $(window).focus(function() {
            titlenotifier.reset();
        });
    </script>
<?php } ?>

<?php if (isset($D->msg_alert) && !empty($D->msg_alert)) {?>
    <script>
        alert('<?php echo $D->msg_alert?>')
    </script>
<?php } ?>

<?php if ($K->WITH_GDPR) { ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js" <?php $D->_IS_LOGGED ? : 'defer'; ?>></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
    <script>
        window.addEventListener("load", function(){
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": "#5371AA",
                        "text": "#fff"
                    },
                    "button": {
                        "background": "#4A6598"
                    }
                },
                "theme": "edgeless",
                "position": "bottom-left",
                "content": {
                    "message": '<?php echo $this->lang('global_txt_gdpr_1'); ?>',
                    "dismiss": '<?php echo $this->lang('global_txt_gdpr_2'); ?>',
                    "link": '<?php echo $this->lang('global_txt_gdpr_3'); ?>',
                    "href": _SITE_URL + "info/privacy"
                  }
            })
        });
    </script>
    <style>
    .cc-revoke, .cc-window{ font-size:15px; }
    .cc-color-override--1450254973.cc-window{ border-radius:7px; }
    .cc-floating.cc-theme-edgeless .cc-message{ margin:20px 20px 15px; }
    </style>
<?php } ?>

</div>

    <!--[if (lt IE 9) & (!IEMobile)]>
    <script src="<?php echo $K->SITE_URL ?>themes/<?php echo $K->THEME; ?>/js/selectivizr.min.js"></script>
    <![endif]-->

    <?php
        // Important - do not remove this:
        if ($K->DEBUG_MODE && $K->DEBUG_CONSOLE) $this->load_template('debug-console.php');
    ?>

    <?php
        @include( $K->INCPATH.'../themes/include_in_footer.php' );
    ?> 
</body>
</html>