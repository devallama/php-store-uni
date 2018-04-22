<?php
require('./classes/auth.php');
require('./classes/db.php');
require('./classes/form_validator.php');

$database = new database();
$validator = new formValidator();

$response = [];

$form_data = [
    'search_term' => [
        'name' => 'Search Term',
        'data' => isset($_GET['searchterm']) ? $_GET['searchterm'] : '',
        'validation' => [
            'required' => true,
        ],
    ],
];

$validator->validate($form_data);

if(!$validator->hasError) {
    $sql = 'SELECT * FROM products WHERE name = :search_term';
    $db_response = $database->fetch($form_data, $sql);

    $response['success'] = true;
    $response['results'] = $db_response;
    
    returnResponse($response);
} else {
    $response['success'] = false;
    $response['message'] = $validator->errorMessages[0];
    
    returnResponse($response);
}

function returnResponse($response) {
    $response_JSON = json_encode($response);
    echo $response_JSON;

    exit();
}