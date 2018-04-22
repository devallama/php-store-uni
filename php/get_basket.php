<?php
require('./classes/util.php');
require('./classes/auth.php');
require('./classes/db.php');

loggedInOnly();

$database = new database();

$response = [];

$input_data = [
    'username' => [
        'data' => getUser(),
    ],
];

$sql = "SELECT * FROM basket WHERE username = :username";

$basket_items = $database->fetch($input_data, $sql);

if($basket_items) {
    $basket = [];
    $itemList = [];
    foreach($basket_items as $basket_item) {
        array_push($itemList, $basket_item['productID']);
    }
    $in = join(',', array_fill(0, count($basket_items), '?'));
    $sql = "SELECT * FROM products WHERE ID IN (" . $in . ")";
    $products = $database->fetchWithArray($itemList, $sql);

    if($products) {
        foreach($basket_items as $basket_item) {
            foreach($products as $product) {
                if($product['ID'] == $basket_item['productID']) {
                    $basket_entry = array_merge($product, $basket_item);
                    array_push($basket, $basket_entry);
                    break;
                }
            }
        }

        $response['success'] = true;
        $response['results'] = $basket;
        returnResponse($response);
    }
} else {
    $response['success'] = false;
    $response['message'] = 'No items in basket.';
    returnResponse($response);
}

function returnResponse($response) {
    $response_JSON = json_encode($response);
    echo $response_JSON;
    
    exit();
}