<div class="content_audio">
    <audio class="mep_audio" style="width: 100%;" controls>
            <source src="<?php echo((isset($D->is_shared) && $D->is_shared) ? $D->shared->file_src : $D->file_src); ?>">
    </audio>
</div>