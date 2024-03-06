<?php

    // dumps (displays) the contents on the screen
    function dd($value){
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        die();
    };

    // finds out if a given url is the active page
    function urlIs($value){
        return $_SERVER['REQUEST_URI'] === $value;
    }

    // gets the time since a timestamp (e.g. '3 days ago')
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