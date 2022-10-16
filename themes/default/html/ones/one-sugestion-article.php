<div class="article-sugestion">

    <a href="<?php echo $K->SITE_URL; ?>article/<?php echo $D->article_sug->code; ?>" <?php echo($D->_IS_LOGGED ? 'rel="phantom-all" target="dashboard-main-area"' : '') ?>>
    <div class="container-info">

        <div class="container-image">
            <div class="theimage" style="background-image:url(<?php echo $D->article_sug->photo; ?>);"></div>
        </div>    
        <div class="container-name">
            <div class="thetitle"><?php echo($D->article_sug->title); ?></div>
            <div class="textby"><span class="theby"><?php echo $this->lang('library_txt_by')?></span> <span class="thename"><?php echo(stripslashes($D->the_writer_a->firstname).' '.stripslashes($D->the_writer_a->lastname)); ?></span></div>
        </div>

    </div>
    </a>

</div>