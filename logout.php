<?php
require('./php/classes/auth.php');

logout();

$_SESSION['response'] = [
    'message' => 'Successfully logged out.',
];

header('Location: ./index.php');