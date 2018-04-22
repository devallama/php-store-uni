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
            'exists' => [false, 'username', 'users', $database],
        ],
    ],
    'password' => [
        'name' => 'Password',
        'data' => $_POST['password'],
        'validation' => [
            'required' => true,
        ],
    ],
    'confirm_password' => [
        'name' => 'Confirm Password',
        'data' => $_POST['confirm_password'],
        'validation' => [
            'required' => true,
            'matches' => 'password',
        ],
        'clientsideOnly' => true,
    ],
    'dayofbirth' => [
        'name' => 'Day of Birth',
        'data' => $_POST['dayofbirth'],
        'validation' => [
            'required' => true,
        ],
    ],
    'monthofbirth' => [
        'name' => 'Month of Birth',
        'data' => $_POST['monthofbirth'],
        'validation' => [
            'required' => true,
        ],
    ],
    'yearofbirth' => [
        'name' => 'Year of Birth',
        'data' => $_POST['yearofbirth'],
        'validation' => [
            'required' => true,
        ],
    ],
];

$validator->validate($form_data);

if(!$validator->hasError) {
    $sql = 'INSERT INTO users (username, password, dayofbirth, monthofbirth, yearofbirth) VALUES ( :username , :password , :dayofbirth , :monthofbirth , :yearofbirth )';
    $db_response = $database->process($form_data, $sql);

    if($db_response) {
        loginUser($form_data['username'], 0);
        $response['success'] = true;
        $response['message'] = "Successfully signed up.";
        
        returnResponse($response, '../index.php');
    } else {
        $response['success'] = false;
        $response['message'] = "There was an error with this request, please try again.";
        $response['previous_data'] = setPreviousData($form_data);
    
        returnResponse($response, '../signup.php');
    }
} else {
    $response['success'] = false;
    $response['message'] = $validator->errorMessages[0];
    $response['previous_data'] = setPreviousData($form_data);
    
    returnResponse($response, '../signup.php');
}

function setPreviousData($form_data) {
    $previous_data['username'] = $form_data['username']['data'];
    $previous_data['dayofbirth'] = $form_data['dayofbirth']['data'];
    $previous_data['monthofbirth'] = $form_data['monthofbirth']['data'];
    $previous_data['yearofbirth'] = $form_data['yearofbirth']['data'];
    return $previous_data;
}

function returnResponse($response, $location) {
    $_SESSION['response'] = $response;

    header('Location: ' . $location);

    exit();
}