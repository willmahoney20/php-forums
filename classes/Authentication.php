<?php

class Authentication {
	// create a new user
	public function login(){
		global $db;

        try {
            $username = strtolower($_POST['username']);
    
            $rec = $db
                ->query("
                    SELECT
                        *
                    FROM
                        forum_users
                    WHERE
                        (username = :username
                        OR
                        email = :email)
                        AND 
                        status = :status
                        
                ", [
                    'username' => $username,
                    'email' => $username,
                    'status' => ACTIVE_STATUS
                ])
                ->findOne();

            if($rec && password_verify($_POST['password'], $rec['password'])){
                $this->setLoggedIn($rec);
            } else {
                Helpers::setNotification('Sorry, your login details are incorrect.', 'login-error');

                return false;
            }
        
            header("Location: " . "/posts");
            exit;
        } catch (PDOException $e) {
            Helpers::setNotification('Sorry, something went wrong.', 'login-error');

            return false;
        }
    }

	public static function setLoggedIn($user){
		global $db;

        $_SESSION['auth'] = new stdClass;

        $_SESSION['auth']->user = new stdClass;
        $_SESSION['auth']->user->id = $user['id'];
        $_SESSION['auth']->user->name = $user['name'];
        $_SESSION['auth']->user->username = $user['username'];
        $_SESSION['auth']->user->created = $user['created'];
        $_SESSION['auth']->user->profile_picture = $user['profile_picture'];

        $db->query("
            UPDATE forum_users
            SET last_login = :last_login
            WHERE id = :id
        ", [
            'last_login' => date("Y-m-d H:i:s", time()),
            'id' => $user->id
        ]);
	}
}
