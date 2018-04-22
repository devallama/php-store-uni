<?php
require('./classes/util.php');
require('./classes/auth.php');
require('./classes/db.php');
require('./classes/form_validator.php');

loggedInOnly();

$database = new database();
$validator = new formValidator();

$response = [];

$form_data = [
    'basketID' => [
        'name' => 'Basket ID',
        'data' => $_POST['basketID'],
        'validation' => [
            'required' => true,
        ],
    ],
];

$validator->validate($form_data);

// TODO: Add qty back to product

if(!$validator->hasError) {
    $sql = 'DELETE FROM basket WHERE ID = :basketID';
    $db_response = $database->process($form_data, $sql);
    if($db_response) {
        $response['success'] = true;
        $response['results'] = 'Successfully removed from basket.';
        returnResponse($response);
    } else {
        $response['success'] = false;
        $response['message'] = 'Could not process request, please try again later.';
        returnResponse($response);
    }
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