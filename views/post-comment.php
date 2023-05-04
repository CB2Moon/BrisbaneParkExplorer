<?php
require_once('../lib/private.php');
require_once('../lib/mysql.php');
require_once('../lib/queries.php');

$is_post = $_POST['isPost'];

if ($is_post) {
    $title = $_POST['title'];
    $words = $_POST['words'];
    $sender = $_POST['sender'];
    if ($sender == 'Anonymous') {
        $sender .= rand(0,19);
    }
    $is_activity = $_POST['isActivity'];
    insertPost($title, $words, $sender, $is_activity);
    echo 'Post successfully!';
} else {
    $words = $_POST['words'];
    $post_id = $_POST['post_id'];
    insertComment($post_id, $words);
    echo 'Reply sent!';
}