<?php
    // Headers
    header('Access-control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate user object
    $user = new User($db);

    // user query
    $user->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get post
    $user->read_single();

    // Create array
    $user_arr = array(
        'id' => $user->id,
        'firstName' => $user->firstName,
        'lastName' => $user->lastName,
        'username' => $user->username,
        'createdOn' => $user->createdOn
    );

    // Encode to JSON
    print_r(json_encode($user_arr));
?>
    