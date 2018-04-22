<?php
    require('./php/classes/util.php');
    require('./php/classes/auth.php');

    $form_previousInputs = [
        'username' => '',
        'dayofbirth' => '',
        'monthofbirth' => '',
        'yearofbirth' => '',
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
    <title>Solent E-Stores - Signup</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <header>
        <a href="./index.php" class="title">Solent E-Stores</a>
        <nav>
            <ul>
                <?php 
                    if(isLoggedIn()) {
                ?>
                        <li>
                            Hello <?php echo getUser(); ?>
                        </li>
                        <li>
                            <a href="./logout.php">Logout</a>
                        </li>
                <?php
                    } else {
                ?>
                        <li>
                            <a href="./login.php">Login</a>
                        </li>
                        <li>
                            <a href="./signup.php">Signup</a>
                        </li>
                <?php 
                    } 
                ?>
            </ul>
        </nav>
    </header>
    <div id="wrap">
        <h2>Signup to Solent E-Stores</h2>
        <?php 
            HTMLRaw($responseHandler['output']);
        ?>
        <form action="./php/signup.php" method="POST" name="form_signup" class="form form--signup">
            <label for="username">Username</label>
            <input type="text" name="username" value="<?php HTMLEscaped($previousData['username']); ?>" />
            <label for="password">Password</label>
            <input type="password" name="password" />
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" />
            <label for="birth">Birthday</label>
            <input type="number" name="dayofbirth" class="form__input--birth" value="<?php HTMLEscaped($previousData['dayofbirth']); ?>" />
            <input type="number" name="monthofbirth" class="form__input--birth" value="<?php HTMLEscaped($previousData['monthofbirth']); ?>" />
            <input type="number" name="yearofbirth" class="form__input--birth" value="<?php HTMLEscaped($previousData['yearofbirth']); ?>" />
            <input type="submit" value="Signup" />
        </form>
    </div>
</body>
</html>