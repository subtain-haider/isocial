<div class="box-activity" style="margin-bottom:10px;">

    <div class="sugestion-peoples">
    
        <div class="title-bar"><?php echo $this->lang('global_txt_trending'); ?></div>
        
        <div class="the-body">
        
            <?php if (empty($D->html_hashtags)) { ?> 
            
            <div class="theempty"><?php echo $this->lang('global_txt_no_items'); ?></div>
            
            <?php } else { ?>
            
            <div class="list-sug-people">
                <?php echo $D->html_hashtags; ?>
            </div>
            
            <?php } ?>

        
        </div>
    
    
    </div>
    
</div>