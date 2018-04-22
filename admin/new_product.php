<?php
    require('../php/classes/util.php');
    require('../php/classes/auth.php');

    adminOnly();

    $form_previousInputs = [
        'name' => '',
        'price' => '',
        'manufacturer' => '',
        'description' => '',
        'stock' => '',
        'age_limit' => '',
    ];

    $responseHandler = handleResponse($form_previousInputs);
    $previousData = $responseHandler['previous_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Places To Stay</title>
</head>
<body>
    <?php 
        HTMLRaw($responseHandler['output']);
    ?>
    <div id="wrap">
        <h2>New Product</h2>
        <form class="form form--new-product" action="../php/process_new_product.php" method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?php HTMLEscaped($previousData['name']); ?>" />
            <label for="price">Price</label>
            <input type="text" name="price" value="<?php HTMLEscaped($previousData['price']); ?>" />
            <label for="manufacturer">Manufacturer</label>
            <input type="text" name="manufacturer" value="<?php HTMLEscaped($previousData['manufacturer']); ?>" />
            <label for="description">Description</label>
            <textarea name="description"><?php HTMLEscaped($previousData['description']); ?></textarea>
            <label for="stock">Stock</label>
            <input type="number" name="stock" value="<?php HTMLEscaped($previousData['stock']); ?>" />
            <label for="age_limit">Age Limit</label>
            <input type="number" name="age_limit" value="<?php HTMLEscaped($previousData['age_limit']); ?>" />
            <input type="submit" value="Create new product" />
        </form> 
    </div>
</body>
</html>