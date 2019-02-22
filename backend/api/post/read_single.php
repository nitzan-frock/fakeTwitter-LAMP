<?php
    // Headers
    header('Access-control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new Post($db);

    // Blog post query
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get post
    $post->read_single();

    // Create array
    $post_arr = array(
        'id' => $post->id,
        'author' => $post->author,
        'body' => $post->body,
        'createdOn' => $post->createdOn
    );

    // Encode to JSON
    print_r(json_encode($post_arr));
?>
    