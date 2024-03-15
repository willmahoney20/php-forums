<?php

class Comments {
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