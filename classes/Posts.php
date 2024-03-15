<?php

class Posts {
	public function getAllPosts(){
		global $db;

		$recs = $db
			->query("
				SELECT
					forum_posts.*,
					forum_users.username,
					forum_users.profile_picture,
					COUNT(forum_comments.id) AS comments_count
				FROM
					forum_posts
				JOIN
					forum_users ON forum_posts.user_id = forum_users.id
				LEFT JOIN
					forum_comments ON forum_posts.id = forum_comments.post_id
				GROUP BY
					forum_posts.id,
					forum_users.username,
					forum_users.profile_picture
				ORDER BY
					forum_posts.created DESC;
			")
			->findAll();

		return $recs;
	}

	// gets all the data for one post
	public function getOnePost($hash){
		global $db;

		$output = new stdClass;
		$output->comments = [];

		$rec = $db
			->query("
				SELECT
					forum_posts.*,
					forum_users.username,
					forum_users.profile_picture,
					JSON_ARRAYAGG(
						JSON_OBJECT(
							'id', forum_comments.id,
							'username', comment_users.username,
							'profile_picture', comment_users.profile_picture,
							'content', forum_comments.content,
							'created', forum_comments.created,
							'parent_id', forum_comments.parent_id
						)
					) AS comments,
					COUNT(forum_comments.id) AS comments_count
				FROM
					forum_posts
				JOIN
					forum_users ON forum_posts.user_id = forum_users.id
				LEFT JOIN
					forum_comments ON forum_posts.id = forum_comments.post_id
				LEFT JOIN
					forum_users AS comment_users ON forum_comments.user_id = comment_users.id
				WHERE
					forum_posts.id = :id
			", ['id' => $hash])
			->findOne();

		if(!$rec || !$rec['id']) return false;
		
		$post = new stdClass;
		$post->id = $rec['id'];
		$post->user_id = $rec['user_id'];
		$post->username = $rec['username'];
		$post->profile_picture = $rec['profile_picture'];
		$post->content = $rec['content'];
		$post->created = $rec['created'];
		$post->comments_count = $rec['comments_count'];

		$output->post = $post;
		
		$comments = json_decode($rec['comments']);
		
		if($comments[0] && $comments[0]->id){
			$output->comments = (new Comments)->organiseComments($comments);
		}

		return $output;
	}

	// gets the 'content' for one post
	public function getOnePostContent($hash){
		global $db;

		$rec = $db
			->query("
				SELECT forum_posts.*, forum_users.username, forum_users.profile_picture
				FROM forum_posts
				JOIN forum_users ON forum_posts.user_id = forum_users.id
				WHERE forum_posts.id = :id;
			", ['id' => $hash])
			->findOne();

		return $rec;
	}

	public function createPost(){
		global $db;

		$db->query("
			INSERT INTO forum_posts (content, user_id)
			VALUES (:content, :user_id)
		", [
			'content' => htmlspecialchars($_POST['content']),
			'user_id' => 1
		]);

		Helpers::redirectSelf();
	}

	public function editPost(){
		global $db;

		$db->query("
			UPDATE forum_posts
			SET content = :content
			WHERE id = :id
		", [
			'content' => htmlspecialchars($_POST['content']),
			'id' => $_POST['id']
		]);

		header("Location: " . "/posts");
	}

	public function deletePost(){
		global $db;

		$db->query("
			DELETE FROM forum_posts
			WHERE id = :id
		", [
			'id' => $_POST['deleteId']
		]);

		header("Location: " . "/posts");
	}
}