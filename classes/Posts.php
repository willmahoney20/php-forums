<?php

class Posts {
	public function getAllPosts(){
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

	public function getOnePost($hash){
		global $db;

		$rec = $db
			->query("
				SELECT forum_posts.*, forum_users.username
				FROM forum_posts
				JOIN forum_users ON forum_posts.user_id = forum_users.id
				WHERE forum_posts.id = :id
				ORDER BY forum_posts.created DESC;
			", ['id' => $hash])
			->fetch(PDO::FETCH_ASSOC);

		return $rec;
	}
}