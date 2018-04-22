<?php
require('./classes/auth.php');
require('./classes/db.php');
require('./classes/form_validator.php');

$database = new database();
$validator = new formValidator();

$response = [];

$form_data = [
    'username' => [
        'name' => 'Username',
        'data' => $_POST['username'],
        'validation' => [
            'required' => true,
            'exists' => [true, 'username', 'users', $database],
        ],
    ],
    'password' => [
        'name' => 'Password',
        'data' => $_POST['password'],
        'validation' => [
            'required' => true,
        ],
    ],
];

$validator->validate($form_data);

if(!$validator->hasError) {
    $sql = 'SELECT * FROM users WHERE username = :username AND password = :password';
    $db_response = $database->fetch($form_data, $sql, true);

    if($db_response) {
        loginUser($db_response['username'], $db_response['isadmin']);
        $response['success'] = true;
        $response['message'] = "Successfully logged in.";
        
        returnResponse($response, '../index.php');
    } else {
        $response['success'] = false;
        $response['message'] = "Login incorrect, please try again.";
        $response['previous_data']['username']  = $form_data['username']['data'];
    
        returnResponse($response, '../login.php');
    }
} else {
    $response['success'] = false;
    $response['message'] = $validator->errorMessages[0];
    $response['previous_data']['username'] = $form_data['username']['data'];

    returnResponse($response, '../login.php');
}

function returnResponse($response, $location) {
    $_SESSION['response'] = $response;

    header('Location: ' . $location);

    exit();
}

