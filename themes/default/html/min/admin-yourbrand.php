               <script>_ID_MENU_LEFT = '<?php echo(isset($D->id_menu) ? $D->id_menu : '')?>';</script>

               <?php if(isset($D->js_script_min)) echo $D->js_script_min;?>

                <div id="admin-main-area">

                    <div class="box-white mrg30B">

                        <div class="box-white-header">
                            <div class="ico"><img src="<?php echo getImageTheme('ico-admin-yourbrand.png')?>"></div>
                            <div class="title"><?php echo $this->lang('admin_general_title')?></div>
                            <div class="clear"></div>
                        </div>

                        <div class="box-white-body">


                            <!-- 1 -->
                            <div class="areablock space-in-admin">

                                <div class="subtitle"><?php echo $this->lang('admin_yourbrand_block_toplogo_out_title')?></div>

                                    <div id="form_01" class="mrg30B">
                                    
                                        <form id="form01" name="form01" method="post" action="">
                                        
                                            <div class="form-block">
                                                <label for="imageupload01"><?php echo $this->lang('admin_yourbrand_block_toplogo_out')?> (140 x 30 px):</label>
                                                <div id="imageupload01" class="space_up_brand" title="<?php echo $this->lang('admin_txt_click_for_upload')?>">
                                                <?php if (empty($D->img_top_logo_out)) { ?>
                                                    <div id="imagepreview01" class="theimgpreview prevbgblue"><div id="msgupload01" class="themsgupl txtwhite"><?php echo $this->lang('admin_txt_click_for_upload')?></div></div>
                                                <?php } else {?>
                                                    <div id="imagepreview01" class="theimgpreview prevbgblue"><img src="<?php echo(getImageMisc($D->img_top_logo_out)).'?r:'.getCode(7, 1); ?>" alt=""></div>
                                                 <?php } ?>
            
                                                </div>
                                                
                                                <input type="file" accept="image/*" class="hide" id="imagenfile01" name="imagenfile01">
                                                <input id="changeimg01" name="changeimg01" value="0" type="hidden">
                                                <script>
                                                
                                                (function($) {
                                                    "use strict";
                                                
                                                    $('#imageupload01')[0].ondragover = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload01').addClass('hover');
                                                    };
                                                    
                                                    $('#imageupload01')[0].ondragleave = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload01').removeClass('hover');
                                                        return false;
                                                    };
                                                    
                                                    $('#imageupload01')[0].ondrop = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload01').removeClass('hover');
                                                        var dt = e.dataTransfer;
                                                        var files = dt.files;
                                                        var result = handleFiles(files, 'imagepreview01', 1);
                                                        if (result) $('#changeimg01').val('1'); 
                                                        $('.msgupload01').hide();
                                                    };
                                                    
                                                    $('#imageupload01').on("click", function(e){
                                                        $("#imagenfile01").click();
                                                    });
                                                    
                                                    $("#imagenfile01").on("change", function(e) {
                                                        $("#imagepreview01").html("<img src='" + window.URL.createObjectURL(this.files[0]) + "' alt=''>");
                                                        $('#changeimg01').val('1');
                                                    });
                                                    
                                                })(jQuery);
                                                
                                                </script>
                                            </div>
                                            <div id="msgerror01" class="alert alert-red hide"></div>
                                            <div id="msgok01" class="alert alert-green hide"></div>
                                            <div class="mrg20T centered">
                                                <span><input type="submit" name="bsave01" id="bsave01" value="<?php echo $this->lang('admin_txt_save_changes')?>" class="my-btn my-btn-blue"/></span>
                                                <div id="preload-01" class="k-preloader hide"></div>
                                            </div>
                                        
                                        </form>
                                        
                                    </div>


                            </div>


                            <!-- 2 -->
                            <div class="areablock space-in-admin">

                                <div class="subtitle"><?php echo $this->lang('admin_yourbrand_block_toplogo_inside_title')?></div>

                                    <div id="form_02" class="mrg30B">
                                    
                                        <form id="form02" name="form02" method="post" action="">
                                        
                                            <div class="form-block">
                                                <label for="imageupload02"><?php echo $this->lang('admin_yourbrand_block_toplogo_inside')?> (140 x 30 px):</label>
                                                <div id="imageupload02" class="space_up_brand" title="<?php echo $this->lang('admin_txt_click_for_upload')?>">
                                                <?php if (empty($D->img_top_logo_in)) { ?>
                                                    <div id="imagepreview02" class="theimgpreview prevbgblue"><div id="msgupload02" class="themsgupl txtwhite"><?php echo $this->lang('admin_txt_click_for_upload')?></div></div>
                                                <?php } else {?>
                                                    <div id="imagepreview02" class="theimgpreview prevbgblue"><img src="<?php echo(getImageMisc($D->img_top_logo_in)).'?r:'.getCode(7, 1); ?>" alt=""></div>
                                                 <?php } ?>
            
                                                </div>
                                                
                                                <input type="file" accept="image/*" class="hide" id="imagenfile02" name="imagenfile02">
                                                <input id="changeimg02" name="changeimg02" value="0" type="hidden">
                                                <script>
                                                (function($) {
                                                    "use strict";

                                                    $('#imageupload02')[0].ondragover = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload02').addClass('hover');
                                                    };
                                                    
                                                    $('#imageupload02')[0].ondragleave = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload02').removeClass('hover');
                                                        return false;
                                                    };
                                                    
                                                    $('#imageupload02')[0].ondrop = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload02').removeClass('hover');
                                                        var dt = e.dataTransfer;
                                                        var files = dt.files;
                                                        var result = handleFiles(files, 'imagepreview02', 1);
                                                        if (result) $('#changeimg02').val('1'); 
                                                        $('.msgupload02').hide();
                                                    };
                                                    
                                                    $('#imageupload02').on("click", function(e){
                                                        $("#imagenfile02").click();
                                                    });
                                                    
                                                    $("#imagenfile02").on("change", function(e) {
                                                        $("#imagepreview02").html("<img src='" + window.URL.createObjectURL(this.files[0]) + "' alt=''>");
                                                        $('#changeimg02').val('1');
                                                    });
                                                    
                                                })(jQuery);
                                                
                                                </script>
                                            </div>
                                            <div id="msgerror02" class="alert alert-red hide"></div>
                                            <div id="msgok02" class="alert alert-green hide"></div>
                                            <div class="mrg20T centered">
                                                <span><input type="submit" name="bsave02" id="bsave02" value="<?php echo $this->lang('admin_txt_save_changes')?>" class="my-btn my-btn-blue"/></span>
                                                <div id="preload-02" class="k-preloader hide"></div>
                                            </div>
                                        
                                        </form>
                                        
                                    </div>


                            </div>

                            <!-- 3 -->
                            <div class="areablock space-in-admin">

                                <div class="subtitle"><?php echo $this->lang('admin_yourbrand_block_isotipotop_out_title')?></div>

                                    <div id="form_03" class="mrg30B">
                                    
                                        <form id="form03" name="form03" method="post" action="">
                                        
                                            <div class="form-block">
                                                <label for="imageupload03"><?php echo $this->lang('admin_yourbrand_block_isotipotop_out')?> (40 x 30 px):</label>
                                                <div id="imageupload03" class="space_up_brand" title="<?php echo $this->lang('admin_txt_click_for_upload')?>">
                                                <?php if (empty($D->img_isotipo_out)) { ?>
                                                    <div id="imagepreview03" class="theimgpreview prevbgblue"><div id="msgupload03" class="themsgupl txtwhite"><?php echo $this->lang('admin_txt_click_for_upload')?></div></div>
                                                <?php } else {?>
                                                    <div id="imagepreview03" class="theimgpreview prevbgblue"><img src="<?php echo(getImageMisc($D->img_isotipo_out)).'?r:'.getCode(7, 1); ?>" alt=""></div>
                                                 <?php } ?>
            
                                                </div>
                                                
                                                <input type="file" accept="image/*" class="hide" id="imagenfile03" name="imagenfile03">
                                                <input id="changeimg03" name="changeimg03" value="0" type="hidden">
                                                <script>
                                                (function($) {
                                                    "use strict";
                                                
                                                    $('#imageupload03')[0].ondragover = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload03').addClass('hover');
                                                    };
                                                    
                                                    $('#imageupload03')[0].ondragleave = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload03').removeClass('hover');
                                                        return false;
                                                    };
                                                    
                                                    $('#imageupload03')[0].ondrop = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload03').removeClass('hover');
                                                        var dt = e.dataTransfer;
                                                        var files = dt.files;
                                                        var result = handleFiles(files, 'imagepreview03', 1);
                                                        if (result) $('#changeimg03').val('1'); 
                                                        $('.msgupload03').hide();
                                                    };
                                                    
                                                    $('#imageupload03').on("click", function(e){
                                                        $("#imagenfile03").click();
                                                    });
                                                    
                                                    $("#imagenfile03").on("change", function(e) {
                                                        $("#imagepreview03").html("<img src='" + window.URL.createObjectURL(this.files[0]) + "' alt=''>");
                                                        $('#changeimg03').val('1');
                                                    });
                                                    
                                                })(jQuery);
                                                
                                                </script>
                                            </div>
                                            <div id="msgerror03" class="alert alert-red hide"></div>
                                            <div id="msgok03" class="alert alert-green hide"></div>
                                            <div class="mrg20T centered">
                                                <span><input type="submit" name="bsave03" id="bsave03" value="<?php echo $this->lang('admin_txt_save_changes')?>" class="my-btn my-btn-blue"/></span>
                                                <div id="preload-03" class="k-preloader hide"></div>
                                            </div>
                                        
                                        </form>
                                        
                                    </div>


                            </div>

                            <!-- 4 -->
                            <div class="areablock space-in-admin">

                                <div class="subtitle"><?php echo $this->lang('admin_yourbrand_block_isotipotop_in_title')?></div>

                                    <div id="form_04" class="mrg30B">
                                    
                                        <form id="form04" name="form04" method="post" action="">
                                        
                                            <div class="form-block">
                                                <label for="imageupload04"><?php echo $this->lang('admin_yourbrand_block_isotipotop_in')?> (40 x 30 px):</label>
                                                <div id="imageupload04" class="space_up_brand" title="<?php echo $this->lang('admin_txt_click_for_upload')?>">
                                                <?php if (empty($D->img_isotipo_in)) { ?>
                                                    <div id="imagepreview04" class="theimgpreview prevbgblue"><div id="msgupload04" class="themsgupl txtwhite"><?php echo $this->lang('admin_txt_click_for_upload')?></div></div>
                                                <?php } else {?>
                                                    <div id="imagepreview04" class="theimgpreview prevbgblue"><img src="<?php echo(getImageMisc($D->img_isotipo_in)).'?r:'.getCode(7, 1); ?>" alt=""></div>
                                                 <?php } ?>
            
                                                </div>
                                                
                                                <input type="file" accept="image/*" class="hide" id="imagenfile04" name="imagenfile04">
                                                <input id="changeimg04" name="changeimg04" value="0" type="hidden">
                                                <script>
                                                
                                                (function($) {
                                                    "use strict";
                                                
                                                    $('#imageupload04')[0].ondragover = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload04').addClass('hover');
                                                    };
                                                    
                                                    $('#imageupload04')[0].ondragleave = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload04').removeClass('hover');
                                                        return false;
                                                    };
                                                    
                                                    $('#imageupload04')[0].ondrop = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload04').removeClass('hover');
                                                        var dt = e.dataTransfer;
                                                        var files = dt.files;
                                                        var result = handleFiles(files, 'imagepreview04', 1);
                                                        if (result) $('#changeimg04').val('1'); 
                                                        $('.msgupload04').hide();
                                                    };
                                                    
                                                    $('#imageupload04').on("click", function(e){
                                                        $("#imagenfile04").click();
                                                    });
                                                    
                                                    $("#imagenfile04").on("change", function(e) {
                                                        $("#imagepreview04").html("<img src='" + window.URL.createObjectURL(this.files[0]) + "' alt=''>");
                                                        $('#changeimg04').val('1');
                                                    });
                                                    
                                                })(jQuery);
                                                
                                                </script>
                                            </div>
                                            <div id="msgerror04" class="alert alert-red hide"></div>
                                            <div id="msgok04" class="alert alert-green hide"></div>
                                            <div class="mrg20T centered">
                                                <span><input type="submit" name="bsave04" id="bsave04" value="<?php echo $this->lang('admin_txt_save_changes')?>" class="my-btn my-btn-blue"/></span>
                                                <div id="preload-04" class="k-preloader hide"></div>
                                            </div>
                                        
                                        </form>
                                        
                                    </div>


                            </div>

                            <!-- 5 -->
                            <div class="areablock space-in-admin">

                                <div class="subtitle"><?php echo $this->lang('admin_yourbrand_block_welcome_dash_title')?></div>

                                    <div id="form_05" class="mrg30B">
                                    
                                        <form id="form05" name="form05" method="post" action="">
                                        
                                            <div class="form-block">
                                                <label for="imageupload05"><?php echo $this->lang('admin_yourbrand_block_welcome_dash')?> (200 x 150 px):</label>
                                                <div id="imageupload05" class="space_up_brand" title="<?php echo $this->lang('admin_txt_click_for_upload')?>">
                                                <?php if (empty($D->img_welc_dash)) { ?>
                                                    <div id="imagepreview05" class="theimgpreview"><div id="msgupload05" class="themsgupl"><?php echo $this->lang('admin_txt_click_for_upload')?></div></div>
                                                <?php } else {?>
                                                    <div id="imagepreview05" class="theimgpreview"><img src="<?php echo(getImageMisc($D->img_welc_dash)).'?r:'.getCode(7, 1); ?>" alt=""></div>
                                                 <?php } ?>
            
                                                </div>
                                                
                                                <input type="file" accept="image/*" class="hide" id="imagenfile05" name="imagenfile05">
                                                <input id="changeimg05" name="changeimg05" value="0" type="hidden">
                                                <script>
                                                (function($) {
                                                    "use strict";

                                                    $('#imageupload05')[0].ondragover = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload05').addClass('hover');
                                                    };
                                                    
                                                    $('#imageupload05')[0].ondragleave = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload05').removeClass('hover');
                                                        return false;
                                                    };
                                                    
                                                    $('#imageupload05')[0].ondrop = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload05').removeClass('hover');
                                                        var dt = e.dataTransfer;
                                                        var files = dt.files;
                                                        var result = handleFiles(files, 'imagepreview05', 1);
                                                        if (result) $('#changeimg05').val('1'); 
                                                        $('.msgupload05').hide();
                                                    };
                                                    
                                                    $('#imageupload05').on("click", function(e){
                                                        $("#imagenfile05").click();
                                                    });
                                                    
                                                    $("#imagenfile05").on("change", function(e) {
                                                        $("#imagepreview05").html("<img src='" + window.URL.createObjectURL(this.files[0]) + "' alt=''>");
                                                        $('#changeimg05').val('1');
                                                    });
                                                    
                                                })(jQuery);
                                                
                                                </script>
                                            </div>
                                            <div id="msgerror05" class="alert alert-red hide"></div>
                                            <div id="msgok05" class="alert alert-green hide"></div>
                                            <div class="mrg20T centered">
                                                <span><input type="submit" name="bsave05" id="bsave05" value="<?php echo $this->lang('admin_txt_save_changes')?>" class="my-btn my-btn-blue"/></span>
                                                <div id="preload-05" class="k-preloader hide"></div>
                                            </div>
                                        
                                        </form>
                                        
                                    </div>

                            </div>

                            <!-- 6 -->
                            <div class="areablock space-in-admin">

                                <div class="subtitle"><?php echo $this->lang('admin_yourbrand_block_favicon_title')?></div>

                                    <div id="form_06" class="mrg30B">
                                    
                                        <form id="form06" name="form06" method="post" action="">
                                        
                                            <div class="form-block">
                                                <label for="imageupload06"><?php echo $this->lang('admin_yourbrand_block_favicon')?> (PNG 100 x 100 px):</label>
                                                <div id="imageupload06" class="space_up_brand" title="<?php echo $this->lang('admin_txt_click_for_upload')?>">
                                                <?php if (empty($D->img_favicon)) { ?>
                                                    <div id="imagepreview06" class="theimgpreview"><div id="msgupload06" class="themsgupl"><?php echo $this->lang('admin_txt_click_for_upload')?></div></div>
                                                <?php } else {?>
                                                    <div id="imagepreview06" class="theimgpreview"><img src="<?php echo(getImageMisc($D->img_favicon)).'?r:'.getCode(7, 1); ?>" alt=""></div>
                                                 <?php } ?>
            
                                                </div>
                                                
                                                <input type="file" accept="image/*" class="hide" id="imagenfile06" name="imagenfile06">
                                                <input id="changeimg06" name="changeimg06" value="0" type="hidden">
                                                <script>
                                                (function($) {
                                                    "use strict";

                                                    $('#imageupload06')[0].ondragover = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload06').addClass('hover');
                                                    };
                                                    
                                                    $('#imageupload06')[0].ondragleave = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload06').removeClass('hover');
                                                        return false;
                                                    };
                                                    
                                                    $('#imageupload06')[0].ondrop = function(e) {
                                                        e.stopPropagation();
                                                        e.preventDefault();
                                                        $('#imageupload06').removeClass('hover');
                                                        var dt = e.dataTransfer;
                                                        var files = dt.files;
                                                        var result = handleFiles(files, 'imagepreview06', 1);
                                                        if (result) $('#changeimg06').val('1'); 
                                                        $('.msgupload06').hide();
                                                    };
                                                    
                                                    $('#imageupload06').on("click", function(e){
                                                        $("#imagenfile06").click();
                                                    });
                                                    
                                                    $("#imagenfile06").on("change", function(e) {
                                                        $("#imagepreview06").html("<img src='" + window.URL.createObjectURL(this.files[0]) + "' alt=''>");
                                                        $('#changeimg06').val('1');
                                                    });
                                                    
                                                })(jQuery);
                                                
                                                </script>
                                            </div>
                                            <div id="msgerror06" class="alert alert-red hide"></div>
                                            <div id="msgok06" class="alert alert-green hide"></div>
                                            <div class="mrg20T centered">
                                                <span><input type="submit" name="bsave06" id="bsave06" value="<?php echo $this->lang('admin_txt_save_changes')?>" class="my-btn my-btn-blue"/></span>
                                                <div id="preload-06" class="k-preloader hide"></div>
                                            </div>
                                        
                                        </form>
                                        
                                    </div>


                            </div>
                            
                            

                        </div>

                    </div>     

                </div>

                <?php if (isset($D->titlePhantom) && !empty($D->titlePhantom)) { ?>
                <div id="newtitlesite" style="display:none;"><?php echo $D->titlePhantom?></div>
                <?php } ?>

<script>

    var txt_error_notimage = stripslashes('<?php echo strJS($this->lang('admin_yourbrand_error_notimage'))?>');
    var txt_error_notformat = stripslashes('<?php echo strJS($this->lang('admin_yourbrand_error_notformat'))?>');

    $('#bsave01').on("click", function(e){
        e.preventDefault();
        updateYourBrand('#msgerror01', '#msgok01', '#bsave01', '#preload-01', '01');
    });

    $('#bsave02').on("click", function(e){
        e.preventDefault();
        updateYourBrand('#msgerror02', '#msgok02', '#bsave02', '#preload-02', '02');
    });
    
    $('#bsave03').on("click", function(e){
        e.preventDefault();
        updateYourBrand('#msgerror03', '#msgok03', '#bsave03', '#preload-03', '03');
    });
    
    $('#bsave04').on("click", function(e){
        e.preventDefault();
        updateYourBrand('#msgerror04', '#msgok04', '#bsave04', '#preload-04', '04');
    });
    
    $('#bsave05').on("click", function(e){
        e.preventDefault();
        updateYourBrand('#msgerror05', '#msgok05', '#bsave05', '#preload-05', '05');
    });

    $('#bsave06').on("click", function(e){
        e.preventDefault();
        updateYourBrand('#msgerror06', '#msgok06', '#bsave06', '#preload-06', '06');
    });

    markMenuLeft('admin');
    makeMenuResp('admin')

</script>