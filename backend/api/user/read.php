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

    //user query for all users
    $result = $user->read();
    // number of users
    $num = $result->rowCount();

    // check if users exist
    if ($num > 0) {
        // users array
        $users_arr = array();
        // user data array
        $users_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_item = array(
                'id' => $id,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $username,
                'createdOn' => $createdOn
            );

            // push to data array
            array_push($users_arr['data'], $user_item);

            // turn to JSON & output

            echo json_encode($users_arr);
        }
    } else {
        // No Users
        echo json_encode(
            array('message' => 'No Users Found')
        );
    }
?>
    