<?php
require('./classes/auth.php');
require('./classes/db.php');
require('./classes/form_validator.php');

$database = new database();

$response = [];

$sql = 'SELECT * FROM products';
$db_response = $database->fetchWithArray(array(), $sql);

$response['success'] = true;
$response['results'] = $db_response;

returnResponse($response);

function returnResponse($response) {
    $response_JSON = json_encode($response);
    echo $response_JSON;

    exit();
}