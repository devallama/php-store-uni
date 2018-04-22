<?php
    require('./php/classes/auth.php');
    require('./php/classes/util.php');

    loggedInOnly();

    $responseHandler = handleResponse();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solent E-Stores</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script src="./js/ajax/ajax_request.js" async defer></script>
    <script src="./js/ajax/get_basket.js" async defer></script>
    <script src="./js/ajax/remove_from_basket.js" async defer></script>
</head>
<body>
    <header>
        <a href="./index.php" class="title">Solent E-Stores</a>
        <nav>
            <ul>
                <li>
                    Hello <?php echo getUser(); ?>
                </li>
                <li>
                    <a href="./basket.php">Basket</a>
                </li>
                <li>
                    <a href="./logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <?php 
        HTMLRaw($responseHandler['output']);
    ?>
    <div id="action-response"></div>
    <div id="wrap">
        <h2>Your Basket</h2>
        <div class="products">
            <div class="products__labels">
                <div class="productname">
                    Product Name
                </div>
                <div class="description">
                    Description
                </div>
                <div class="manufacturer">
                    Manufacturer
                </div>
                <div class="qty">
                    Quantity
                </div>
                <div class="price">
                    Total Price
                </div>
                <div>

                </div>
            </div>
            <div id="basket__results">
                <div data-basket-id="0">
                    <div class="name">Product name</div>
                    <div class="manufacturer">Manufacturer</div>
                    <div class="description">Description</div>
                    <div class="price">Price</div>
                    <div class="qty">Quantity</div>
                    <div class="delete"><a href="#" data-action="removefrombasket" class="button button--remove">Remove From Basket</a></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>