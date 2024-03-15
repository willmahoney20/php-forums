<?php

class Comments {
	public function createComment($hash){
		global $db;

		$db->query("
			INSERT INTO forum_comments (post_id, content, user_id, parent_id)
			VALUES (:post_id, :content, :user_id, :parent_id)
		", [
            'post_id' => $hash,
			'content' => htmlspecialchars($_POST['content']),
			'user_id' => 2,
            'parent_id' => 0
		]);

		Helpers::redirectSelf();
	}

    public function organiseComments($comments, $parentId = 0){
        $nestedComments = array();

        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                $comment->replies = $this->organiseComments($comments, $comment->id);
                $nestedComments[] = $comment;
            }
        }
    
        // Sort the nested comments chronologically (most recent first)
        usort($nestedComments, function($a, $b) {
            return strtotime($b->created) - strtotime($a->created);
        });
    
        return $nestedComments;
    }
}