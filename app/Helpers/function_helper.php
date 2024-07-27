<?php

if (!function_exists('pre')) {
    function pre($data, $die = FALSE){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if($die) die;
        return false;
    }
}

?>