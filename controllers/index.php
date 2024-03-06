<?php

require_once 'db.php';

$content = "";
$error = false;
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
    if(empty($_POST['content'])){
        $error = true;
    } elseif(strlen($_POST['content']) > 255){
        $error = true;
        $content = $_POST['content'];
    } else {
        try {
            $error = false;

            $sql = "INSERT INTO forum_posts (post_content) VALUES (:content)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':content', htmlspecialchars($_POST['content']));
            $stmt->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
        } catch (PDOException $e) {
            echo '<p style="color: white;">Post Failed: ' . $e->getMessage() . '</p>';
        }
    }
};

$editing = "";
$edited_content = "";

$editError = false;
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])){
    if(empty($_POST['editContent'])){
        $editError = true;
        $editing = $_POST['editId'];
    } elseif(strlen($_POST['editContent']) > 255){
        $editError = true;
        $edited_content = $_POST['editContent'];
        $editing = $_POST['editId'];
    } else {
        try {
            $new_content = htmlspecialchars($_POST['editContent']);
            $editError = false;

            $sql = "UPDATE forum_posts SET post_content = :content WHERE post_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':content', $new_content);
            $stmt->bindParam(':id', $_POST['editId']);
            $stmt->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
        } catch (PDOException $e) {
            echo '<p style="color: white;">Edit Failed: ' . $e->getMessage() . '</p>';
        }
    }
}


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])){
    try {
        if(isset($_POST['deleteId'])){
            $sql = "DELETE FROM forum_posts WHERE post_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $_POST['deleteId']);
            $stmt->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
        }
    } catch (PDOException $e) {
        echo '<p style="color: white;">Delete Failed: ' . $e->getMessage() . '</p>';
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM forum_posts ORDER BY post_created DESC");
    $stmt->execute();

    $result = $stmt->fetchAll();

    if(!$result){
        echo '<p style="color: white;">No posts found</p>';
    }
} catch (PDOException $e) {
    echo '<p style="color: white;">Failed to fetch posts: ' . $e->getMessage() . '</p>';
}

function editPost(){
    global $result;
    global $edited_content;
    global $editing;
    $editing = $_GET['editPost'];

    for($i = 0; $i < count($result); $i++){
        if($result[$i]['post_id'] == $_GET['editPost']){
            $edited_content = $result[$i]['post_content'];
        }
    };
}

if(isset($_GET['editPost'])) {
    editPost();
}

require "views/index.view.php";

?>

<script src="js/post.js"></script>
<script src="js/edit.js"></script>