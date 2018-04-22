<?php
require('./classes/util.php');
require('./classes/auth.php');
require('./classes/db.php');
require('./classes/form_validator.php');

$response = [];

if(!isLoggedIn()) {
    $response['success'] = false;
    $response['message'] = 'You need to be logged in to add products to your basket.';
    returnResponse($response);
}

$database = new database();
$validator = new formValidator();

$product_data = [
    'productID' => [
        'data' => $_POST['productID'],
    ],
];

$sql = "SELECT * FROM products WHERE ID = :productID";

$product_information = $database->fetch($product_data, $sql, true);

if(!$product_information) {
    $response['success'] = false;
    $response['message'] = 'That product does not exist';

    returnResponse($response);
}

$form_data = [
    'productID' => [
        'name' => 'Product ID',
        'data' => $_POST['productID'],
        'validaton' => [
            'required' => true,
        ],
    ],
    'username' => [
        'name' => 'username',
        'data' => $_SESSION['user']['username'],
    ],
    'quantity' => [
        'name' => 'Quantity',
        'data' => $_POST['quantity'],
        'validation' => [
            'required' => true,
            'max' => $product_information['stocklevel'],
        ],
    ],
];

$validator->validate($form_data);

if(!$validator->hasError) {
    $sql = 'INSERT INTO basket (productID, username, qty) VALUES ( :productID , :username , :quantity )';
    $db_response = $database->process($form_data, $sql);
    if($db_response) {
        $product_data['quantity'] = ['data' => $form_data['quantity']['data']];
        $sql = 'UPDATE products SET stocklevel = stocklevel - :quantity WHERE ID = :productID';
        $database->process($product_data, $sql);

        $response['success'] = true;
        $response['results'] = 'Successfully added ' . $form_data['quantity']['data'] . ' ' . $product_information['name'] . ' to basket.';
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