
    <div id="foot-nologin">

        <div class="separator"></div>

        <div id="space-foot-one">
        
            <span class="opc-foot">
                <a href="<?php echo $K->SITE_URL?>marketplace" <?php echo($D->_IS_LOGGED ? 'rel="phantom-all" target="dashboard-main-area"' : '') ?>><span class="opc-foot-text"><?php echo $this->lang('global_opc_foot_marketplace'); ?></span></a>
            </span>
            
            <span class="opc-foot">
                <a href="<?php echo $K->SITE_URL?>library" <?php echo($D->_IS_LOGGED ? 'rel="phantom-all" target="dashboard-main-area"' : '') ?>><span class="opc-foot-text"><?php echo $this->lang('global_opc_foot_library'); ?></span></a>
            </span>

        <?php

        $statics = getStaticsFoot();

        if ($statics) {

            foreach ($statics as $onest) { ?>

            <span class="opc-foot">
                <a href="<?php echo $K->SITE_URL.'info/'.$onest->url?>" <?php echo($D->_IS_LOGGED ? 'rel="phantom-all" target="dashboard-main-area"' : '') ?>><span class="opc-foot-text"><?php echo $onest->title ?></span></a>
            </span>

        <?php 

            }

        } ?>



        </div>

        <div id="space-foot-two">

            <?php echo $K->COMPANY?> &copy; <?php echo date('Y'); ?>

        </div>

        <div class="clear"></div>

    </div>