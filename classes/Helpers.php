<?php

class Helpers {
    // dumps (displays) the contents on the screen
    public static function dump($value){
        echo "<pre class='text-white'>";
        var_dump($value);
        echo "</pre>";
    }

    // dumps (displays) the contents on the screen and then dies
    public static function dd($value){
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        die();
    }

    // checks if a user is logged in
	public static function isLoggedIn($redirectUrl = false){
		$isTrue = (isset($_SESSION['auth']) && !empty($_SESSION['auth']));

		if($isTrue && $redirectUrl){
			header('Location: ' . $redirectUrl);
			exit();
		}

		return $isTrue;
	}

    // check if the user is logged out
	public static function isLoggedOut($redirectUrl = false) {
		$isTrue = (!isset($_SESSION['auth']) || empty($_SESSION['auth']));

		if($isTrue && $redirectUrl){
			header('Location: ' . $redirectUrl);
			exit();
		}

		return $isTrue;
	}

    // logs the user out by removing their session
	public static function logout(){
		unset($_SESSION['auth']);

		header('Location: /login');
		exit();
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
        
        $difference = floor($difference);
        
        return $difference != 1 ? "$difference $periods[$i]s ago" : "$difference $periods[$i] ago";;
    }

    // gets the time in 'Month Year' (e.g. January 2021) format
    public static function dateMonthYear($dateString){
        $date = new DateTime($dateString);
        $formattedDate = $date->format('F Y'); // 'F' represents the full month name and 'Y' represents the four-digit year
        return $formattedDate;
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
	public static function setNotification($notification = '', $type = 'default'){
		$_SESSION['notifications'][$type][] = $notification;
	}
}