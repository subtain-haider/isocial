<?php
$header	= 
'<!DOCTYPE html>
<html>
    <head>
        <title>'.SITE_TITLE.' - Installation</TITLE>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" type="image/png" href="assets/favicon.png"/>
        <link href="assets/css.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="assets/jquery.min.js?v='.VERSION.'"></script>
        <script>var msgbox_to_close	= {};</script>
    </head>
    <body>
    

        <div id="wrapper">

            <div class="container-simple">
                
                <div id="space-top">            
                    <div><img src="assets/logotop.png" alt=""></div>
                    <div class="size20 bold">v'.VERSION.'</div>
                </div>
                

                
                <div class="box-white">
                
                    <div id="header-box">
                        <div id="hb-title">'.$PAGE_TITLE.'</div>';
                        if ($step <= 5) {
                        $header	.= '<div id="hb-steps">Step <span class="bold">'.$step.'</span> of 5</div>';
                        }
                    $header	.= '</div>
';  
?>