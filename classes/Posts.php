<?php

class Posts {
	public function getPosts(){
		global $db;

		$recs = $db
			->query("
				SELECT forum_posts.*, forum_users.username
				FROM forum_posts
				JOIN forum_users ON forum_posts.user_id = forum_users.id
				ORDER BY forum_posts.created DESC;
			")
			->fetchAll(PDO::FETCH_ASSOC);

		return $recs;
	}
}