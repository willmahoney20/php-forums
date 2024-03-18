<?php

class Users {
	// create a new user
	public function createUser(){
		global $db;

		$username = strtolower(trim($_POST['username']));

		if(preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username) == 0){
			Helpers::setNotification('Usernames must be 3-20 characters, and contain letters, numbers and underscores only.', 'signup-error');
			return false;
		}
		
		if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $_POST['password']) == 0){
			Helpers::setNotification('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter and one number.', 'signup-error');
			return false;
		}

		try {
			$user = $db->query("
				INSERT INTO forum_users (status, name, username, email, password)
				VALUES (:status, :name, :username, :email, :password)
			", [
				'status' => ACTIVE_STATUS,
				'name' => $_POST['name'],
				'username' => $username,
				'email' => $_POST['email'],
				'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
			]);
	
			if(!$user) return false;
	
			header("Location: " . "/posts");
			exit;
		} catch (PDOException $e) {
			$errorMessage = $e->getMessage();

			// check email duplicate error, then the username duplicate error, then return a general error
			if(strpos($errorMessage, 'Duplicate entry') !== false && strpos($errorMessage, 'forum_users.email_UNIQUE') !== false){
				Helpers::setNotification('Sorry, this email is already taken.', 'signup-error');
			} else if(strpos($errorMessage, 'Duplicate entry') !== false && strpos($errorMessage, 'forum_users.username_UNIQUE') !== false){
				Helpers::setNotification('Sorry, this username is already taken.', 'signup-error');
			} else {
				Helpers::setNotification('Sorry, something went wrong.', 'signup-error');
			}

			return false;
		}
	}

	// gets a single user
	public function getOneUser($hash){
		global $db;

		$rec = $db
			->query("
				SELECT
                    forum_users.*
				FROM
                    forum_users
				JOIN
                    forum_posts ON forum_users.id = forum_posts.user_id
				WHERE
                    forum_users.username = LOWER(:identifier)
                    OR
                    forum_users.id = :identifier;
			", ['identifier' => $hash])
			->findOne();

		return $rec;
	}
}