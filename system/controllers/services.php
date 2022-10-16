<?php
    require_once('classes/class_services.php');
    $ajax = new services();
    echo $ajax->load();
?>