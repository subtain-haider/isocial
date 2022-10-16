<!DOCTYPE html>
<head>
    <title><?php echo (isset($D->page_title)?$D->page_title:$K->SITE_TITLE); ?></title>
	<meta http-equiv="cleartype" content="on">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    
    <?php if (isset($D->OG_show) && $D->OG_show) { ?>

    <meta property="og:type" content="<?php echo $D->OG_type; ?>" />
    <meta property="og:site_name" content="<?php echo stripslashes($K->SITE_TITLE); ?>">
    <meta property="og:title" content="<?php echo $D->OG_title; ?>">
    <meta property="og:description" content="<?php echo $D->OG_description; ?>">
    <meta property="og:url" content="<?php echo $D->OG_url; ?>">
    <meta property="og:image" content="<?php echo $D->OG_image; ?>"/>

    <?php } else { ?>

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo stripslashes($K->SITE_TITLE); ?>">
    <meta property="og:title" content="<?php echo (isset($D->page_title) ? stripslashes($D->page_title) : stripslashes($K->SITE_TITLE)); ?>">
    <meta property="og:description" content="<?php echo stripslashes($K->SEO_DESCRIPTION); ?>">
    <meta property="og:url" content="<?php echo $K->SITE_URL; ?>">
    <meta property="og:image" content="<?php echo($K->STORAGE_URL_OGS.'og-site.png')?>"/>
    
    <?php } ?>
    
    <base href="<?php echo $K->SITE_URL ?>" />
    <?php echo $D->header_data ?>
    <?php if (isset($D->is_home) && $D->is_home) { ?>
    <link href='//fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
    <?php } ?>
    <?php if (!empty($K->KEY_API_GOOGLE)) { ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $K->KEY_API_GOOGLE;?>&v=3.exp&libraries=places"></script>
    <?php } ?>
    <?php require_once('_analytics.php');?>
</head>
<body<?php echo((isset($D->is_home) && $D->is_home) ? ' class="backhome"' : '')?>>
<div id="wrapper">
<div id="preload-bar"><dd></dd><dt></dt></div>