<?php
    // Headers
    header('Access-control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate user object
    $user = new User($db);

    // Get raw user data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $user->id = $data->id;

    // bind raw data to user object
    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;

    // update user
    if ($user->update()) {
        echo json_encode(
            array('message' => 'User Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'User Not Updated')
        );
    }
?>