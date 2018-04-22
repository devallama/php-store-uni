<?php
require('./classes/util.php');
require('./classes/auth.php');
require('./classes/db.php');
require('./classes/form_validator.php');

adminOnly();

$database = new database();
$validator = new formValidator();

$response;

$form_data = [
    'name' => [
        'name' => 'Product Name',
        'data' => $_POST['name'],
        'validation' => [
            'required' => true,
        ]
    ],
    'price' => [
        'name' => 'Price',
        'data' => $_POST['price'],
        'validation' => [
            'required' => true,
        ],
    ],
    'manufacturer' => [
        'name' => 'Manufacturer',
        'data' => $_POST['manufacturer'],
        'validation' => [
            'required' => true,
        ],
    ],
    'description' => [
        'name' => 'Description',
        'data' => $_POST['description'],
        'validation' => [
            'required' => true,
        ],
    ],
    'stock' => [
        'name' => 'Stock',
        'data' => $_POST['stock'],
        'validation' => [
            'required' => true,
        ],
    ],
    'age_limit' => [
        'name' => 'Age Limit',
        'data' => $_POST['age_limit'],
        'validation' => [
            'required' => true,
        ],
    ],
];

$validator->validate($form_data);

if(!$validator->hasError) {
    $sql = 'INSERT INTO products (name, manufacturer, description, price, stocklevel, agelimit) VALUES ( :name , :manufacturer , :description , :price , :stock , :age_limit)';
    $db_response = $database->process($form_data, $sql);

    if($db_response) {
        $response['success'] = true;
        $response['message'] = "Successfully created new product";

        returnResponse($response, getRootPath() . 'admin/new_product.php');
    } else {
        $response['success'] = false;
        $response['message'] = "There was an error with this request, please try again.";
        $response['previous_data'] = setPreviousData($form_data);
    
        returnResponse($response, getRootPath() . 'admin/new_product.php');
    }
} else {
    $response['success'] = false;
    $response['message'] = $validator->errorMessages[0];
    $response['previous_data'] = setPreviousData($form_data);

    returnResponse($response, getRootPath() . 'admin/new_product.php');
}

function setPreviousData($form_data) {
    $previous_data['name'] = $form_data['name']['data'];
    $previous_data['price'] = $form_data['price']['data'];
    $previous_data['manufacturer'] = $form_data['manufacturer']['data'];
    $previous_data['description'] = $form_data['description']['data'];
    $previous_data['stock'] = $form_data['stock']['data'];
    $previous_data['age_limit'] = $form_data['age_limit']['data'];
    return $previous_data;
}

function returnResponse($response, $location) {
    $_SESSION['response'] = $response;

    header('Location: ' . $location);

    exit();
}