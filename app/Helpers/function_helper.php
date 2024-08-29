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

if (!function_exists('rupiah')) {
    function rupiah($number){
        $formattedNumber = number_format($number, 0, ',', '.');
        return "Rp. ".$formattedNumber; // Output: 1.000.000
    }
}

if (!function_exists('price')) {
    function price($number){
        $formattedNumber = number_format($number, 0, ',', '.');
        return $formattedNumber; // Output: 1.000.000
    }
}

if (!function_exists('badgeStatus')) {
    function badgeStatus($status){
        if($status == 1){
            $badge = '<span class="badge bg-secondary"><i class="bi bi-clock-fill me-1"></i> Waiting for payment</span>';
        }elseif($status == 2){
            $badge = '<span class="badge bg-dark"><i class="bi bi-hourglass-split me-1"></i> Waiting for confirmation</span>';
        }elseif ($status == 3) {
            $badge = '<span class="badge bg-warning"><i class="bi bi-box-seam me-1"></i> Processed</span>';
        }elseif ($status == 4) {
            $badge = '<span class="badge bg-info"><i class="bi bi-truck me-1"></i> Shipping</span>';
        }elseif ($status == 6) {
            $badge = '<span class="badge bg-danger"><i class="bi bi-x-lg me-1"></i> Order Canceled</span>';
        }else{
            $badge = '<span class="badge bg-success"><i class="bi bi-patch-check me-1"></i> Finished</span>';
        }
        return $badge;
    }
}

?>