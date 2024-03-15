<?php

class Users {
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