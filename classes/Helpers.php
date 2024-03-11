<?php

class Helpers {
    // dumps (displays) the contents on the screen
    public static function dd($value){
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        die();
    }

    // redirects the user to the current URI
	public static function redirectSelf(){
		global $CFG;

		header('Location: ' . $CFG->base_url . ltrim($_SERVER['REQUEST_URI'], '/'));
		exit();
	}

    // finds out if a given url is the active page
    public static function urlIs($value){
        return $_SERVER['REQUEST_URI'] === $value;
    }

    // gets the time since a timestamp (e.g. '3 days ago')
    public static function datePosted($dateString){
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

    // the $pageJS is an array of JS files we've added in the routes.php file, this function loops through this array, adding the relevant JS files, this fn will likely be called in the footer
	public static function pageJS(){
		global $pageJS;

		if(empty($pageJS)) return false;

		foreach($pageJS as $file){            
			echo '<script src="' . $file . '"></script>' . "\r\n";
		}
	}

    // adds a notification to the _SESSION super global
	public static function setNotification($notification = '', $type = 'default') {
		$_SESSION['notifications'][$type][] = $notification;
	}
}