<?php

    function datePosted($dateString) {
        $timestamp = strtotime($dateString);
        $currentTimestamp = time();
        
        $difference = $currentTimestamp - $timestamp;
        
        $periods = array("second", "minute", "hour", "day", "week", "month", "year");
        $lengths = array(60, 60, 24, 7, 4.35, 12);
        
        for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i++) {
            $difference /= $lengths[$i];
        }
        
        $difference = round($difference);
        
        if ($difference != 1) {
            $periods[$i] .= "s";
        }
        
        return "$difference $periods[$i] ago";
    }

?>